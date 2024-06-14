<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614080142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maintenances (id INT AUTO_INCREMENT NOT NULL, maintenance_type VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, date DATETIME NOT NULL, car_id INT DEFAULT NULL, INDEX IDX_C2F7112FC3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE maintenances ADD CONSTRAINT FK_C2F7112FC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenances DROP FOREIGN KEY FK_C2F7112FC3C6F69F');
        $this->addSql('DROP TABLE maintenances');
    }
}
