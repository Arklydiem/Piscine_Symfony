<?php

namespace App\Service;

use PDOException;

class AddressService extends Database
{
    public function createTable(): bool
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS addresses (
                id SERIAL PRIMARY KEY,
                number INTEGER,
                road VARCHAR(255) NOT NULL,
                city VARCHAR(255) NOT NULL,
                country VARCHAR(255) NOT NULL
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
