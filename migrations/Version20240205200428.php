<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205200428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars CHANGE km km INT DEFAULT NULL, CHANGE energy energy VARCHAR(255) DEFAULT NULL, CHANGE tank tank INT DEFAULT NULL, CHANGE horsepower horsepower INT DEFAULT NULL, CHANGE gearbox gearbox VARCHAR(255) DEFAULT NULL, CHANGE doors doors INT DEFAULT NULL, CHANGE year year INT DEFAULT NULL, CHANGE color color VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars CHANGE km km INT NOT NULL, CHANGE energy energy VARCHAR(255) NOT NULL, CHANGE tank tank INT NOT NULL, CHANGE horsepower horsepower INT NOT NULL, CHANGE gearbox gearbox VARCHAR(255) NOT NULL, CHANGE doors doors INT NOT NULL, CHANGE year year INT NOT NULL, CHANGE color color VARCHAR(255) NOT NULL');
    }
}
