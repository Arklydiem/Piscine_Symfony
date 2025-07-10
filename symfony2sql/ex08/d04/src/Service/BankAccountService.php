<?php

namespace App\Service;

use PDOException;

class BankAccountService extends Database
{
    public function createTable(): bool
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS bank_accounts (
                id SERIAL PRIMARY KEY,
                iban VARCHAR(34) NOT NULL,
                bank_name VARCHAR(255) NOT NULL
            );
        ";

        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}
