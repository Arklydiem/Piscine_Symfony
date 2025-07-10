<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PersonService;

#[Route('/e08/person', name: 'person_')]
class PersonController extends AbstractController
{
    private PersonService $personService;

    public function __construct(
        PersonService $personService,
    ) {
        $this->personService = $personService;
    }

    #[Route('/createTable', name: 'createTable', methods: ['GET'])]
    public function createTablePersons(Request $request): Response
    {
        $result = $this->personService->createTable();

        $message = $result
            ? 'Table "persons" created successfully or was already created.'
            : 'Error creating the table "persons".';

        $this->addFlash('person_createTable', $message);
        return $this->redirectToRoute('home');
    }

    #[Route('/updateTable', name: 'updateTable', methods: ['GET'])]
    public function updateTablePersons(Request $request): Response
    {
        $result = $this->personService->updateTableAddMaritalStatus();

        $message = $result
            ? 'Table "persons" updated successfully.'
            : 'Error updating the table "persons".';

        $this->addFlash('person_updateTable', $message);
        return $this->redirectToRoute('home');
    }
}
