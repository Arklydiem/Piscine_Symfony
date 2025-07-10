<?php

namespace App\Service;

use App\Entity\SaveOrm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class SaveOrmService
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
            $this->entityManager->getClassMetadata(SaveOrm::class)
        ];

        try {
            $schemaTool->createSchema($classes, true);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function createSaveOrm(string $value): bool
    {
        try {
            $save = new SaveOrm();
            $save->setValue($value);

            $this->entityManager->persist($save);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAllOrmSaves(): array
    {
        return $this->entityManager->getRepository(SaveOrm::class)->findAll();
    }
}
