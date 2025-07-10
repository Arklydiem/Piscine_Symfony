<?php

namespace App\Controller;

use App\Service\SaveOrmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/e10/saveOrm', name: 'save_orm_')]
class SaveOrmController extends AbstractController
{
    private SaveOrmService $saveOrmService;

    public function __construct(
        SaveOrmService $saveOrmService,
    ) {
        $this->saveOrmService = $saveOrmService;
    }

    #[Route('/createTable', name: 'createTable', methods: ['GET'])]
    public function createTable(Request $request): Response
    {
        $result = $this->saveOrmService->createTable();

        $message = $result
            ? 'Table "saves_orm" created successfully or was already created.'
            : 'Error creating the table "saves_orm".';

        $this->addFlash('save_orm_createTable', $message);
        return $this->redirectToRoute('home_home');
    }
}
