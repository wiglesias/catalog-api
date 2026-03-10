<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310155939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation_attribute_value ADD catalog_presentation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation_attribute_value ADD CONSTRAINT FK_540DBAD8D5407724 FOREIGN KEY (catalog_presentation_id) REFERENCES catalog_presentation (id)');
        $this->addSql('CREATE INDEX IDX_540DBAD8D5407724 ON presentation_attribute_value (catalog_presentation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation_attribute_value DROP FOREIGN KEY FK_540DBAD8D5407724');
        $this->addSql('DROP INDEX IDX_540DBAD8D5407724 ON presentation_attribute_value');
        $this->addSql('ALTER TABLE presentation_attribute_value DROP catalog_presentation_id');
    }
}
