<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310002248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT NOT NULL, customer_id INT DEFAULT NULL, INDEX IDX_1B2C32479395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C32479395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE article ADD type VARCHAR(255) NOT NULL, ADD active TINYINT NOT NULL');
        $this->addSql('ALTER TABLE catalog_presentation ADD active TINYINT NOT NULL, ADD catalog_id INT DEFAULT NULL, CHANGE version version INT NOT NULL');
        $this->addSql('ALTER TABLE catalog_presentation ADD CONSTRAINT FK_AA19D25DCC3C66FC FOREIGN KEY (catalog_id) REFERENCES catalog (id)');
        $this->addSql('CREATE INDEX IDX_AA19D25DCC3C66FC ON catalog_presentation (catalog_id)');
        $this->addSql('ALTER TABLE catalog_presentation_component ADD position INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD active TINYINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C32479395C3F3');
        $this->addSql('DROP TABLE catalog');
        $this->addSql('ALTER TABLE article DROP type, DROP active');
        $this->addSql('ALTER TABLE catalog_presentation DROP FOREIGN KEY FK_AA19D25DCC3C66FC');
        $this->addSql('DROP INDEX IDX_AA19D25DCC3C66FC ON catalog_presentation');
        $this->addSql('ALTER TABLE catalog_presentation DROP active, DROP catalog_id, CHANGE version version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE catalog_presentation_component DROP position');
        $this->addSql('ALTER TABLE customer DROP active');
    }
}
