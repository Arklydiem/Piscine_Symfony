<?php

namespace App\Controller;

use App\Service\SaveSqlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/e10/saveSql', name: 'save_sql_')]
class SaveSqlController extends AbstractController
{
    private SaveSqlService $saveSqlService;

    public function __construct(
        SaveSqlService $saveSqlService,
    ) {
        $this->saveSqlService = $saveSqlService;
    }

    #[Route('/createTable', name: 'createTable', methods: ['GET'])]
    public function createTable(Request $request): Response
    {
        $result = $this->saveSqlService->createTable();

        $message = $result
            ? 'Table "saves_sql" created successfully or was already created.'
            : 'Error creating the table "saves_sql".';

        $this->addFlash('save_sql_createTable', $message);
        return $this->redirectToRoute('home_home');
    }
}
