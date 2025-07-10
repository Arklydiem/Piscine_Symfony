<?php

namespace App\Service;

use PDO;
use PDOException;

class DatabaseManager
{
    private $connection;

    public function __construct()
    {
        $dsn = 'pgsql:host=127.0.0.1;port=5432;dbname=app';
        $user = 'postgres';
        $password = '123456';

        try {
            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception('Connection failed: ' . $e->getMessage());
        }
    }

    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            enable BOOLEAN NOT NULL,
            birthdate TIMESTAMP NOT NULL,
            address TEXT NOT NULL
        )";


        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
