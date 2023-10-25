<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025154726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE postcode CHANGE latitude latitude NUMERIC(8, 5) NOT NULL, CHANGE longitude longitude NUMERIC(8, 5) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE postcode CHANGE latitude latitude NUMERIC(5, 0) NOT NULL, CHANGE longitude longitude NUMERIC(5, 0) NOT NULL');
    }
}
