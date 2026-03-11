<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311164140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD barcode VARCHAR(255) DEFAULT NULL, ADD net_weight NUMERIC(10, 4) DEFAULT NULL, ADD gross_weight NUMERIC(10, 4) DEFAULT NULL, ADD length DOUBLE PRECISION DEFAULT NULL, ADD width DOUBLE PRECISION DEFAULT NULL, ADD height DOUBLE PRECISION DEFAULT NULL, ADD track_stock TINYINT DEFAULT 1 NOT NULL, CHANGE unit unit VARCHAR(255) NOT NULL, CHANGE active active TINYINT DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP barcode, DROP net_weight, DROP gross_weight, DROP length, DROP width, DROP height, DROP track_stock, CHANGE unit unit VARCHAR(10) NOT NULL, CHANGE active active TINYINT NOT NULL');
    }
}
