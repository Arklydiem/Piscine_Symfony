<?php

namespace App\Controller;

use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/e09/person', name: 'person_')]
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
        return $this->redirectToRoute('home');
    }

}
