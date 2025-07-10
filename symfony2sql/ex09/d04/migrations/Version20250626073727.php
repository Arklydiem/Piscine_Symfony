<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626073727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE addresses (id SERIAL NOT NULL, number INT NOT NULL, road VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bank_accounts (id SERIAL NOT NULL, iban VARCHAR(255) NOT NULL, bank_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE persons (id SERIAL NOT NULL, bank_account_id INT DEFAULT NULL, address_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, enable BOOLEAN NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, marital_status VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A25CC7D3F85E0677 ON persons (username)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A25CC7D3E7927C74 ON persons (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A25CC7D312CB990C ON persons (bank_account_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A25CC7D3F5B7AF75 ON persons (address_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE persons ADD CONSTRAINT FK_A25CC7D312CB990C FOREIGN KEY (bank_account_id) REFERENCES bank_accounts (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE persons ADD CONSTRAINT FK_A25CC7D3F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE persons DROP CONSTRAINT FK_A25CC7D312CB990C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE persons DROP CONSTRAINT FK_A25CC7D3F5B7AF75
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE addresses
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bank_accounts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE persons
        SQL);
    }
}
