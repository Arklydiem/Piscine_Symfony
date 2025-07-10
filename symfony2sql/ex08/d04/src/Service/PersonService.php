<?php

namespace App\Service;

use PDOException;

class PersonService extends Database
{
    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS persons (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            enable BOOLEAN NOT NULL,
            birthdate TIMESTAMP NOT NULL
        )";

        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateTableAddMaritalStatus(): bool
    {
        $sql = "ALTER TABLE persons
            ADD COLUMN marital_status VARCHAR(255) DEFAULT 'single'";

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function updateTableAddBankAccount(): bool
    {
        $sql = "
        ALTER TABLE persons
        ADD COLUMN bank_account_id INTEGER UNIQUE,
        ADD CONSTRAINT fk_bank_account FOREIGN KEY (bank_account_id) REFERENCES bank_accounts(id)
        ON DELETE SET NULL
        ";

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


    public function updateTableAddAddress(): bool
    {
        $sql = "
        ALTER TABLE persons
        ADD COLUMN address_id INTEGER,
        ADD CONSTRAINT fk_address FOREIGN KEY (address_id) REFERENCES addresses(id)
        ON DELETE SET NULL
    ";

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


}
