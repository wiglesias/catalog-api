<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310002835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE presentation_document (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, ty�pe VARCHAR(50) NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_CA4310664584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE presentation_document ADD CONSTRAINT FK_CA4310664584665A FOREIGN KEY (product_id) REFERENCES catalog_presentation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation_document DROP FOREIGN KEY FK_CA4310664584665A');
        $this->addSql('DROP TABLE presentation_document');
    }
}
