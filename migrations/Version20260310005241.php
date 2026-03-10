<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310005241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, slug VARCHAR(255) NOT NULL, catalog_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, INDEX IDX_349BC7DFCC3C66FC (catalog_id), INDEX IDX_349BC7DF727ACA70 (parent_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE presentation_attribute (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E7DFD50577153098 (code), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE presentation_attribute_value (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) DEFAULT NULL, product_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, INDEX IDX_540DBAD84584665A (product_id), INDEX IDX_540DBAD8B6E62EFA (attribute_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE presentation_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, position INT NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_2358FFFE4584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE catalog_category ADD CONSTRAINT FK_349BC7DFCC3C66FC FOREIGN KEY (catalog_id) REFERENCES catalog (id)');
        $this->addSql('ALTER TABLE catalog_category ADD CONSTRAINT FK_349BC7DF727ACA70 FOREIGN KEY (parent_id) REFERENCES catalog_category (id)');
        $this->addSql('ALTER TABLE presentation_attribute_value ADD CONSTRAINT FK_540DBAD84584665A FOREIGN KEY (product_id) REFERENCES catalog_presentation (id)');
        $this->addSql('ALTER TABLE presentation_attribute_value ADD CONSTRAINT FK_540DBAD8B6E62EFA FOREIGN KEY (attribute_id) REFERENCES presentation_attribute (id)');
        $this->addSql('ALTER TABLE presentation_image ADD CONSTRAINT FK_2358FFFE4584665A FOREIGN KEY (product_id) REFERENCES catalog_presentation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E6677153098 ON article (code)');
        $this->addSql('ALTER TABLE catalog_presentation ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalog_presentation ADD CONSTRAINT FK_AA19D25D12469DE2 FOREIGN KEY (category_id) REFERENCES catalog_category (id)');
        $this->addSql('CREATE INDEX IDX_AA19D25D12469DE2 ON catalog_presentation (category_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09989D9B62 ON customer (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_category DROP FOREIGN KEY FK_349BC7DFCC3C66FC');
        $this->addSql('ALTER TABLE catalog_category DROP FOREIGN KEY FK_349BC7DF727ACA70');
        $this->addSql('ALTER TABLE presentation_attribute_value DROP FOREIGN KEY FK_540DBAD84584665A');
        $this->addSql('ALTER TABLE presentation_attribute_value DROP FOREIGN KEY FK_540DBAD8B6E62EFA');
        $this->addSql('ALTER TABLE presentation_image DROP FOREIGN KEY FK_2358FFFE4584665A');
        $this->addSql('DROP TABLE catalog_category');
        $this->addSql('DROP TABLE presentation_attribute');
        $this->addSql('DROP TABLE presentation_attribute_value');
        $this->addSql('DROP TABLE presentation_image');
        $this->addSql('DROP INDEX UNIQ_23A0E6677153098 ON article');
        $this->addSql('ALTER TABLE catalog_presentation DROP FOREIGN KEY FK_AA19D25D12469DE2');
        $this->addSql('DROP INDEX IDX_AA19D25D12469DE2 ON catalog_presentation');
        $this->addSql('ALTER TABLE catalog_presentation DROP category_id');
        $this->addSql('DROP INDEX UNIQ_81398E09989D9B62 ON customer');
    }
}
