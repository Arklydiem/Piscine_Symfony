<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class UserService
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTable(): bool
    {
        $schemaTool = new SchemaTool($this->entityManager);

        $classes = [
            $this->entityManager->getClassMetadata(User::class)
        ];

        try {
            $schemaTool->createSchema($classes, true);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function createUser(string $username, string $name, string $email, bool $enable, \DateTime $birthdate, string $address): bool
    {
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username, 'email' => $email]);

        if ($existingUser) {
            return false;
        }

        $user = new User();
        $user->setUsername($username);
        $user->setName($name);
        $user->setEmail($email);
        $user->setEnable($enable);
        $user->setBirthdate($birthdate);
        $user->setAddress($address);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }

    public function getUsers(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function getUserById(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    public function updateUser(int $id, string $username, string $name, string $email, bool $enable, \DateTime $birthdate, string $address): bool
    {
        $user = $this->getUserById($id);
        if (!$user) {
            return false;
        }

        $user->setUsername($username);
        $user->setName($name);
        $user->setEmail($email);
        $user->setEnable($enable);
        $user->setBirthdate($birthdate);
        $user->setAddress($address);

        $this->entityManager->flush();
        return true;
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->getUserById($id);
        if (!$user) {
            return false;
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return true;
    }
}
