<?php

namespace App\Service;

use App\Entity\User;
use Exception;
use PDO;
use PDOException;

class SaveSqlService
{
    private $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $dsn = 'pgsql:host=127.0.0.1;port=5432;dbname=app';
        $user = 'postgres';
        $password = '123456';

        try {
            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage());
        }
    }

    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS saves_sql (
            id SERIAL PRIMARY KEY,
            value TEXT
        )";


        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function createSaveSql($value): bool
    {
        $sql = "INSERT INTO saves_sql (value) VALUES (:value)";


        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':value' => $value,
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getSavesSql(): array
    {
        $sql = "SELECT * FROM saves_sql";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $saves = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $saves;
        } catch (PDOException $e) {
            return [];
        }
    }
}
