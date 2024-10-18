<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
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

//    /**
//     * @throws \DateMalformedStringException
//     */
//    #[Route('/e02', name: 'create_user', methods: ['POST'])]
//    public function create(Request $request): Response
//    {
//        $message = null;
//
//        if ($request->isMethod('POST')) {
//            $username = $request->request->get('username');
//            $name = $request->request->get('name');
//            $email = $request->request->get('email');
//            $enable = (bool) $request->request->get('enable');
//            $birthdate = new \DateTime($request->request->get('birthdate'));
//            $address = $request->request->get('address');
//
//            $result = $this->userService->createUser($username, $name, $email, $enable, $birthdate, $address);
//
//            if ($result) {
//                $message = 'User created successfully!';
//            } else {
//                $message = 'Error creating the user.';
//            }
//        }
//
//        return $this->render('user/create_user.html.twig', [
//            'message' => $message,
//        ]);
//    }
//
//
//    #[Route('/e02', name: 'get_users', methods: ['GET'])]
//    public function getUsers(Request $request): Response
//    {
//        $users = $this->userService->getUsers();
//
//        if (empty($users)) {
//            $message = 'No users found.';
//        } else {
//            $message = null;
//        }
//
//        return $this->render('user/table.html.twig', [
//            'users' => $users,
//            'message' => $message,
//        ]);
//    }

}