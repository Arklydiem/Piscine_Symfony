<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $userService;
    private $entityManager;
    private $formFactory;

    public function __construct(
        UserService $userService,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory // Inject the FormFactoryInterface
    ) {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    #[Route('/e05/createUser', name: 'createUser', methods: ['GET', 'POST'])]
    public function createUser(Request $request): Response
    {
        $user = new User();
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a user with the same username or email already exists
            $existingUser = $this->entityManager->getRepository(User::class)->findOneBy([
                'username' => $user->getUsername(),
            ]) ?? $this->entityManager->getRepository(User::class)->findOneBy([
                'email' => $user->getEmail(),
            ]);

            if ($existingUser) {
                $this->addFlash('error', 'Username or email already exists.');
            } else {
                // Only persist if no existing user was found
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $this->redirectToRoute('getUsers');
            }
        }

        return $this->render('user/createUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/e05', name: 'getUsers', methods: ['GET'])]
    public function getUsers(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('user/table.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/e05/delete/{id}', name: 'deleteUser', methods: ['POST'])]
    public function deleteUser(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'User deleted successfully!');
        } else {
            $this->addFlash('error', 'User not found.');
        }

        return $this->redirectToRoute('getUsers');
    }
}