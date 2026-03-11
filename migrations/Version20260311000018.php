<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311000018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_presentation DROP FOREIGN KEY `FK_AA19D25D3F2BC4C`');
        $this->addSql('DROP INDEX IDX_AA19D25D3F2BC4C ON catalog_presentation');
        $this->addSql('ALTER TABLE catalog_presentation DROP catalog_category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_presentation ADD catalog_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalog_presentation ADD CONSTRAINT `FK_AA19D25D3F2BC4C` FOREIGN KEY (catalog_category_id) REFERENCES catalog_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AA19D25D3F2BC4C ON catalog_presentation (catalog_category_id)');
    }
}
