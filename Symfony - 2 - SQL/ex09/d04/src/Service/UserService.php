<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use PDO;
use PDOException;

class UserService
{

    private EntityManagerInterface $entityManager;

    private PDO $connection;

    /**
     * @throws Exception
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $dsn = 'pgsql:host=127.0.0.1;port=5432;dbname=app';
        $user = 'postgres';
        $password = '123456';

        $this->entityManager = $entityManager;

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

    public function updateUser(int $id, $username, $name, $email, $enable, $birthdate, $address): bool
    {
        $sql = "UPDATE users 
            SET username = :username, name = :name, email = :email, enable = :enable, 
                birthdate = :birthdate, address = :address 
            WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':username' => $username,
                ':name' => $name,
                ':email' => $email,
                ':enable' => $enable,
                ':birthdate' => $birthdate->format('Y-m-d H:i:s'),
                ':address' => $address,
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            // Convert the data array to a User object
            $user = new User();
            $user->setUsername($data['username']);
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setEnable($data['enable']);
            $user->setBirthdate(new \DateTime($data['birthdate']));
            $user->setAddress($data['address']);

            return $user;
        } catch (PDOException $e) {
            return null;
        } catch (\DateMalformedStringException $e) {
            return null;
        }
    }

    public function searchUsers(array $criteria): array
    {
        $repository = $this->entityManager->getRepository(User::class);
        $queryBuilder = $repository->createQueryBuilder('u');

        if (!empty($criteria['username'])) {
            $queryBuilder->andWhere('u.username LIKE :username')
                ->setParameter('username', '%' . $criteria['username'] . '%');
        }

        if (!empty($criteria['email'])) {
            $queryBuilder->andWhere('u.email LIKE :email')
                ->setParameter('email', '%' . $criteria['email'] . '%');
        }

        if (!empty($criteria['name'])) {
            $queryBuilder->andWhere('u.name LIKE :name')
                ->setParameter('name', '%' . $criteria['name'] . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function getPaginatedUsers(int $page, int $limit = 10): Paginator
    {
        $repository = $this->entityManager->getRepository(User::class);
        $queryBuilder = $repository->createQueryBuilder('u');

        $queryBuilder->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $query = $queryBuilder->getQuery();

        return new Paginator($query, true);
    }
}
