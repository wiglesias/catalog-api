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
    description: 'Add a short description for your command',
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

        // Convertir automáticamente Windows-1252 a UTF-8
        stream_filter_append($handle, 'convert.iconv.WINDOWS-1252/UTF-8');

        // Detectar delimitador
        $firstLine = fgets($handle);
        $delimiter = substr_count($firstLine, ';') >= substr_count($firstLine, ',') ? ';' : ',';
        rewind($handle);

        $header = fgetcsv($handle, 0, $delimiter);
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        if ($debug) {
            $io->note("Delimiter: $delimiter");
            $io->writeln(implode(' | ', $header));

            for ($i = 0; $i < 5; $i++) {
                $row = fgetcsv($handle, 0, $delimiter);
                if (!$row) break;
                $io->writeln(implode(' | ', $row));
            }

            fclose($handle);
            return Command::SUCCESS;
        }

        $io->progressStart();
        $count = 0;

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {

            if (count($data) < 4) {
                $io->warning("Fila incompleta: " . implode(' | ', $data));
                continue;
            }

            [$code, $name, $unitRaw, $typeRaw] = array_map('trim', $data);

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

            if ($existing) continue;

            $article = new Article();
            $article->setCode($code);
            $article->setName($name);
            $article->setUnit($unit);
            $article->setType($type);

            $this->entityManager->persist($article);
            $io->progressAdvance();
            $count++;

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
