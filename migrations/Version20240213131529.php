<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213131529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts_customers DROP FOREIGN KEY FK_64F0ABBBB171EB6C');
        $this->addSql('DROP INDEX UNIQ_64F0ABBBB171EB6C ON contacts_customers');
        $this->addSql('ALTER TABLE contacts_customers DROP customer_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts_customers ADD customer_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE contacts_customers ADD CONSTRAINT FK_64F0ABBBB171EB6C FOREIGN KEY (customer_id_id) REFERENCES customers (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64F0ABBBB171EB6C ON contacts_customers (customer_id_id)');
    }
}
