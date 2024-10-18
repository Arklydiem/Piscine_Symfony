<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/e01', name: 'create_table', methods: ['GET', 'POST'])]
    public function createTable(Request $request): Response
    {
        $message = null;

        if ($request->isMethod('POST')) {
            $result = $this->userService->createTable();

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
