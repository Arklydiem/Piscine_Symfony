<?php

namespace App\Controller;

use App\Service\AddressService;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/e08/address', name: 'address_')]
class AddressController extends AbstractController
{
    private AddressService $addressService;
    private PersonService $personService;

    public function __construct(
        AddressService $addressService,
        PersonService $personService,
    ) {
        $this->addressService= $addressService;
        $this->personService= $personService;
    }

    #[Route('/createTable', name: 'createTable', methods: ['GET'])]
    public function createTable(Request $request): Response
    {
        $message = null;

        $addressCreated = $this->addressService->createTable();
        $personAltered = false;

        if ($addressCreated) {
            $personAltered = $this->personService->updateTableAddAddress();
        }

        if ($addressCreated && $personAltered) {
            $message = 'Table "addresses" created and foreign key added to "persons".';
        } elseif (!$addressCreated) {
            $message = 'Error creating the table "addresses".';
        } elseif (!$personAltered) {
            $message = 'Table created, but failed to add foreign key to "persons".';
        }

        $this->addFlash('address_createTable', $message);
        return $this->redirectToRoute('home');
    }

}
