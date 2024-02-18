<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218153743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracts ADD price INT NOT NULL, ADD type INT NOT NULL, ADD customer_id INT NOT NULL, ADD car_id INT NOT NULL');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A9739395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A973C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_950A9739395C3F3 ON contracts (customer_id)');
        $this->addSql('CREATE INDEX IDX_950A973C3C6F69F ON contracts (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracts DROP FOREIGN KEY FK_950A9739395C3F3');
        $this->addSql('ALTER TABLE contracts DROP FOREIGN KEY FK_950A973C3C6F69F');
        $this->addSql('DROP INDEX IDX_950A9739395C3F3 ON contracts');
        $this->addSql('DROP INDEX IDX_950A973C3C6F69F ON contracts');
        $this->addSql('ALTER TABLE contracts DROP price, DROP type, DROP customer_id, DROP car_id');
    }
}
