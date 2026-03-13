<?php

namespace App\Command;

use App\Entity\Article;
use App\Enum\ArticleType;
use App\Enum\UnitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:articles',
    description: 'Import articles from CSV'
)]
class ImportArticlesCommand extends Command
{
    private const BATCH_SIZE = 50;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'file',
                InputArgument::OPTIONAL,
                'Ruta del CSV',
                __DIR__ . '/../../../docs-to-import/articles.csv'
            )
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                'Muestra las primeras filas sin importar'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');
        $debug = $input->getOption('debug');

        if (!file_exists($file)) {
            $io->error("Archivo no encontrado: $file");
            return Command::FAILURE;
        }

        $handle = fopen($file, 'r');

        if (!$handle) {
            $io->error("No se pudo abrir el CSV");
            return Command::FAILURE;
        }

        // Detectar delimitador
        $firstLine = fgets($handle);
        $firstLine = mb_convert_encoding($firstLine, 'UTF-8', 'UTF-8, Windows-1252, ISO-8859-1');

        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',')
            ? ';'
            : ',';

        rewind($handle);

        // Leer header
        $header = fgetcsv($handle, 0, $delimiter);

        if (!$header) {
            $io->error("No se pudo leer la cabecera del CSV");
            return Command::FAILURE;
        }

        // Limpiar BOM
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        // Normalizar header
        $header = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = preg_replace('/\s+/', '_', $h); // espacios -> _
            return $h;
        }, $header);

        if ($debug) {
            $io->note("Delimiter: {$delimiter}");
            $io->note("Header detectado:");
            $io->writeln(implode(' | ', $header));
        }

        // Mapear columnas por nombre
        $map = array_flip($header);

        // Permitir alias de columnas
        $columnAliases = [
            'code' => ['code', 'article_code', 'codigo'],
            'name' => ['name', 'article_name', 'nombre'],
            'unit' => ['unit', 'unidad'],
            'type' => ['type', 'article_type', 'tipo'],
        ];

        $columnIndex = [];

        foreach ($columnAliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                if (isset($map[$alias])) {
                    $columnIndex[$key] = $map[$alias];
                    break;
                }
            }

            if (!isset($columnIndex[$key])) {
                $io->error("Columna requerida '{$key}' no encontrada en CSV.");
                return Command::FAILURE;
            }
        }

        if ($debug) {
            $io->text("Column mapping:");
            foreach ($columnIndex as $k => $v) {
                $io->writeln("$k -> column {$v}");
            }

            $io->text("Primeras filas:");

            for ($i = 0; $i < 5; $i++) {
                $line = fgets($handle);
                if (!$line) break;

                $line = mb_convert_encoding($line, 'UTF-8', 'UTF-8, Windows-1252, ISO-8859-1');
                $data = str_getcsv($line, $delimiter);

                $io->writeln(implode(' | ', $data));
            }

            fclose($handle);
            return Command::SUCCESS;
        }

        $io->progressStart();
        $count = 0;

        while (($line = fgets($handle)) !== false) {

            $line = mb_convert_encoding($line, 'UTF-8', 'UTF-8, Windows-1252, ISO-8859-1');
            $line = preg_replace('/[\x00-\x1F\x7F]/u', '', $line);

            $data = str_getcsv($line, $delimiter);

            if (!$data || count($data) < 4) {
                $io->warning("Fila incompleta: " . implode(' | ', $data ?? []));
                continue;
            }

            $code = trim($data[$columnIndex['code']] ?? '');
            $name = trim($data[$columnIndex['name']] ?? '');
            $unitRaw = trim($data[$columnIndex['unit']] ?? '');
            $typeRaw = trim($data[$columnIndex['type']] ?? '');

            $unit = UnitType::fromLabel($unitRaw);
            $type = ArticleType::fromLabel($typeRaw);

            if (!$unit) {
                $io->warning("Unidad inválida '{$unitRaw}' para artículo {$code}");
                continue;
            }

            if (!$type) {
                $io->warning("Tipo inválido '{$typeRaw}' para artículo {$code}");
                continue;
            }

            $existing = $this->entityManager
                ->getRepository(Article::class)
                ->findOneBy(['code' => $code]);

            if ($existing) {
                continue;
            }

            $article = new Article();
            $article->setCode($code);
            $article->setName($name);
            $article->setUnit($unit);
            $article->setType($type);

            $this->entityManager->persist($article);

            $count++;
            $io->progressAdvance();

            if ($count % self::BATCH_SIZE === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        fclose($handle);

        $this->entityManager->flush();
        $this->entityManager->clear();

        $io->progressFinish();
        $io->success("Importación completada. Artículos importados: $count");

        return Command::SUCCESS;
    }
}

//class ImportArticlesCommand extends Command
//{
//    private const BATCH_SIZE = 50;
//
//    public function __construct(private EntityManagerInterface $entityManager)
//    {
//        parent::__construct();
//    }
//
//    protected function configure(): void
//    {
//        $this
//            ->addArgument(
//                'file',
//                InputArgument::OPTIONAL,
//                'Ruta del archivo CSV',
//                __DIR__ . '/../../../docs-to-import/articles.csv'
//            )
//            ->addOption(
//                'debug',
//                null,
//                InputOption::VALUE_NONE,
//                'Muestra las primeras filas del CSV sin importar nada'
//            );
//    }
//
//    protected function execute(InputInterface $input, OutputInterface $output): int
//    {
//        $io = new SymfonyStyle($input, $output);
//        $file = $input->getArgument('file');
//        $debug = $input->getOption('debug');
//
//        if (!file_exists($file)) {
//            $io->error("El archivo CSV no existe en: $file");
//            return Command::FAILURE;
//        }
//
//        $handle = fopen($file, 'r');
//        if ($handle === false) {
//            $io->error("No se pudo abrir el archivo CSV.");
//            return Command::FAILURE;
//        }
//
//        // Detectar delimitador
//        $firstLine = fgets($handle);
//        if ($firstLine === false) {
//            $io->error("El CSV está vacío.");
//            fclose($handle);
//            return Command::FAILURE;
//        }
//
//        $delimiter = substr_count($firstLine, ';') >= substr_count($firstLine, ',') ? ';' : ',';
//        rewind($handle);
//
//        $header = fgetcsv($handle, 0, $delimiter);
//        if ($header === false) {
//            $io->error("No se pudo leer la cabecera del CSV.");
//            fclose($handle);
//            return Command::FAILURE;
//        }
//
//        // Limpiar BOM
//        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
//
//        if ($debug) {
//            $io->note("Delimiter detected: '{$delimiter}'");
//            $io->text('Header:');
//            $io->writeln(implode(' | ', $header));
//
//            $io->text('First 5 data rows:');
//            for ($i = 0; $i < 5; $i++) {
//                $data = fgetcsv($handle, 0, $delimiter);
//                if ($data === false) break;
//                $io->writeln(implode(' | ', $data));
//            }
//
//            fclose($handle);
//            return Command::SUCCESS;
//        }
//
//        $io->progressStart();
//        $count = 0;
//
//        while (($line = fgets($handle)) !== false) {
//
//            $line = mb_convert_encoding($line, 'UTF-8', 'Windows-1252');
//            $data = str_getcsv($line, $delimiter);
//
//            if (count($data) < 4) {
//                $io->warning("Fila incompleta: " . implode(' | ', $data));
//                continue;
//            }
//
//            [$code, $name, $unitRaw, $typeRaw] = array_map('trim', $data);
//
//            // Validar enums
//            $unit = UnitType::tryFrom($unitRaw);
//            $type = ArticleType::tryFrom($typeRaw);
//
//            if (!$unit) {
//                $io->warning("Unidad inválida '{$unitRaw}' para artículo {$code}");
//                continue;
//            }
//
//            if (!$type) {
//                $io->warning("Tipo inválido '{$typeRaw}' para artículo {$code}");
//                continue;
//            }
//
//            // Evitar duplicados
//            $existing = $this->entityManager
//                ->getRepository(Article::class)
//                ->findOneBy(['code' => $code]);
//
//            if ($existing) {
//                $io->warning("Artículo ya existe: {$code}");
//                continue;
//            }
//
//            $article = new Article();
//            $article->setCode($code);
//            $article->setName($name);
//            $article->setUnit($unit);
//            $article->setType($type);
//
//            // los demás campos usan defaults
//            $this->entityManager->persist($article);
//
//            $count++;
//            $io->progressAdvance();
//
//            if ($count % self::BATCH_SIZE === 0) {
//                $this->entityManager->flush();
//                $this->entityManager->clear();
//            }
//        }
//
//        fclose($handle);
//
//        $this->entityManager->flush();
//        $this->entityManager->clear();
//
//        $io->progressFinish();
//        $io->success("Importación completada. Artículos importados: $count");
//
//        return Command::SUCCESS;
//    }
//}
