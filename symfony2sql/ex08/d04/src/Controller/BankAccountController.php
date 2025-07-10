<?php

namespace App\Controller;

use App\Service\BankAccountService;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/e08/bank_account', name: 'bank_account_')]
class BankAccountController extends AbstractController
{
    private BankAccountService $bankAccountService;
    private PersonService $personService;

    public function __construct(
        BankAccountService $bankAccountService,
        PersonService $personService,
    ) {
        $this->bankAccountService= $bankAccountService;
        $this->personService= $personService;
    }

    #[Route('/createTable', name: 'createTable', methods: ['GET'])]
    public function createTable(Request $request): Response
    {
        $message = null;

        $bankResult = $this->bankAccountService->createTable();
        $personResult = false;

        if ($bankResult) {
            $personResult = $this->personService->updateTableAddBankAccount();
        }

        if ($bankResult && $personResult) {
            $message = 'Table "bank_accounts" created and foreign key added to "persons".';
        } elseif (!$bankResult) {
            $message = 'Error creating the table "bank_accounts".';
        } elseif (!$personResult) {
            $message = 'Table created, but failed to add foreign key to "persons".';
        }

        $this->addFlash('bank_account_createTable', $message);
        return $this->redirectToRoute('home');
    }

}
