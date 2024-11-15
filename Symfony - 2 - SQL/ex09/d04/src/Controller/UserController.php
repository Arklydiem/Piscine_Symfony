<?php

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private UserService $userService;
    private FormFactoryInterface $formFactory;

    public function __construct(
        UserService $userService,
        FormFactoryInterface $formFactory // Inject the FormFactoryInterface
    ) {
        $this->userService = $userService;
        $this->formFactory = $formFactory;
    }

    #[Route('/e09/createTable', name: 'createTable', methods: ['GET', 'POST'])]
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

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/e09/createUser', name: 'createUser', methods: ['POST', 'GET'])]
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

    #[Route('/e09', name: 'getUsers', methods: ['GET'])]
    public function getUsers(Request $request): Response
    {
        $users = $this->userService->getUsers();

        $message = empty($users) ? 'No users found.' : null;

        return $this->render('user/table.html.twig', [
            'users' => $users,
            'message' => $message,
        ]);
    }

    #[Route('/e09/delete/{id}', name: 'deleteUser', methods: ['POST', 'GET'])]
    public function deleteUser(int $id): Response
    {
        $message = null;

        $result = $this->userService->deleteUser($id);

        if ($result) {
            $message = 'User deleted successfully!';
        } else {
            $message = 'Error deleting the user or user not found.';
        }

        // Redirect back to the user list with a message
        return $this->redirectToRoute('getUsers', ['message' => $message]);
    }

    #[Route('/e09/update/{id}', name: 'updateUser', methods: ['GET', 'POST'])]
    public function updateUser(int $id, Request $request): Response
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            $this->addFlash('error', 'User not found.');
            return $this->redirectToRoute('getUsers');
        }

        // Populate form with existing user data
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $result = $this->userService->updateUser(
                $id,
                $data->getUsername(),
                $data->getName(),
                $data->getEmail(),
                $data->isEnable(),
                $data->getBirthdate(),
                $data->getAddress()
            );

            if ($result) {
                $this->addFlash('success', 'User updated successfully!');
            } else {
                $this->addFlash('error', 'Error updating the user.');
            }

            return $this->redirectToRoute('getUsers');
        }

        return $this->render('user/updateUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/e09/search', name: 'searchUsers', methods: ['GET'])]
    public function searchUsers(Request $request): Response
    {
        $criteria = [
            'username' => $request->query->get('username'),
            'email' => $request->query->get('email'),
            'name' => $request->query->get('name'),
        ];

        $users = $this->userService->searchUsers($criteria);

        $message = empty($users) ? 'No results found.' : null;

        return $this->render('user/search.html.twig', [
            'users' => $users,
            'message' => $message,
        ]);
    }

    #[Route('/e09/users', name: 'paginatedUsers', methods: ['GET'])]
    public function paginatedUsers(Request $request): Response
    {
        $page = max(1, (int) $request->query->get('page', 1)); // Default to page 1
        $limit = 10; // Number of results per page

        $paginator = $this->userService->getPaginatedUsers($page, $limit);

        return $this->render('user/paginatedUsers.html.twig', [
            'users' => $paginator,
            'currentPage' => $page,
            'totalPages' => ceil($paginator->count() / $limit),
        ]);
    }
}
