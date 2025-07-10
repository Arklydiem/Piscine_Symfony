<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use App\Entity\User;

class UserService
{
    private $entityManager;

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
}
