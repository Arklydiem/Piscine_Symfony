<?php

namespace App\Controller;

use App\Service\PersonService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(PersonService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/e02/createTable', name: 'createTable', methods: ['GET', 'POST'])]
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

    #[Route('/e02/createUser', name: 'createUser', methods: ['POST', 'GET'])]
    public function create(Request $request): Response
    {
        $message = null;

        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $enable = (bool) $request->request->get('enable');
            $birthdate = new \DateTime($request->request->get('birthdate'));
            $address = $request->request->get('address');

            $result = $this->userService->createUser($username, $name, $email, $enable, $birthdate, $address);

            if ($result) {
                $message = 'User created successfully!';
            } else {
                $message = 'Error creating the user.';
            }
        }

        return $this->render('user/createUser.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/e02', name: 'getUsers', methods: ['GET'])]
    public function getUsers(Request $request): Response
    {
        $result = $this->userService->getUsers();

        $users = [];
        $message = null;

        if (is_string($result) && str_starts_with($result, 'error:')) {
            $message = 'La table "users" n\'existe pas.';
        } elseif (empty($result)) {
            $message = 'La table "users" est vide.';
        } else {
            $users = $result;
        }

        return $this->render('user/table.html.twig', [
            'users' => $users,
            'message' => $message,
        ]);
    }

}
