<?php

namespace App\Service;

use Exception;
use PDO;
use PDOException;

class UserService
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
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            enable BOOLEAN NOT NULL,
            birthdate TIMESTAMP NOT NULL,
            address TEXT NOT NULL,
            CONSTRAINT unique_username_email UNIQUE (username, email)
        )";


        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function createUser($username, $name, $email, $enable, $birthdate, $address): bool
    {
        $sql = "INSERT INTO users (username, name, email, enable, birthdate, address) 
        VALUES (:username, :name, :email, :enable, :birthdate, :address)
        ON CONFLICT (username, email) DO NOTHING";


        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':name' => $name,
                ':email' => $email,
                ':enable' => $enable,
                ':birthdate' => $birthdate->format('Y-m-d H:i:s'),
                ':address' => $address,
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUsers(): array
    {
        $sql = "SELECT * FROM users";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function deleteUser(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0; // Returns true if a row was deleted
        } catch (PDOException $e) {
            return false;
        }
    }

}
