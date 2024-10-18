<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DatabaseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    #[Route('/e00', name: 'create_table', methods: ['GET', 'POST'])]
    public function createTable(Request $request): Response
    {
        $message = null;

        if ($request->isMethod('POST')) {
            $result = $this->databaseManager->createTable();

            if ($result) {
                $message = 'Table created successfully!';
            } else {
                $message = 'Error creating the table.';
            }
        }

        return $this->render('user/createTable.html.twig', [
            'message' => $message,
        ]);
    }
}
