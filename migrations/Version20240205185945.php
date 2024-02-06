<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205185945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, km INT NOT NULL, reg_number VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, energy VARCHAR(255) NOT NULL, tank INT NOT NULL, horsepower INT NOT NULL, gearbox VARCHAR(255) NOT NULL, doors INT NOT NULL, dayprice INT NOT NULL, buyprice INT NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cars');
    }
}
