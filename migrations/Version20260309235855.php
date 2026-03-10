<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260309235855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE catalog_presentation (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, version VARCHAR(255) DEFAULT NULL, customer_id INT DEFAULT NULL, INDEX IDX_AA19D25D9395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE catalog_presentation_component (id INT AUTO_INCREMENT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(10) NOT NULL, product_id INT DEFAULT NULL, article_id INT DEFAULT NULL, INDEX IDX_F256C22D4584665A (product_id), INDEX IDX_F256C22D7294869C (article_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE catalog_presentation ADD CONSTRAINT FK_AA19D25D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE catalog_presentation_component ADD CONSTRAINT FK_F256C22D4584665A FOREIGN KEY (product_id) REFERENCES catalog_presentation (id)');
        $this->addSql('ALTER TABLE catalog_presentation_component ADD CONSTRAINT FK_F256C22D7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_presentation DROP FOREIGN KEY FK_AA19D25D9395C3F3');
        $this->addSql('ALTER TABLE catalog_presentation_component DROP FOREIGN KEY FK_F256C22D4584665A');
        $this->addSql('ALTER TABLE catalog_presentation_component DROP FOREIGN KEY FK_F256C22D7294869C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE catalog_presentation');
        $this->addSql('DROP TABLE catalog_presentation_component');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
