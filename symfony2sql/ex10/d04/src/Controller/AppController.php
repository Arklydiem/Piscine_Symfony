<?php

namespace App\Controller;

use App\Service\FileReaderService;
use App\Service\SaveOrmService;
use App\Service\SaveSqlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/e10', name: 'home_')]
class AppController extends AbstractController
{
    private FileReaderService $fileReader;
    private SaveSqlService $saveSql;
    private SaveOrmService $saveOrm;

    public function __construct(FileReaderService $fileReader, SaveSqlService $saveSql, SaveOrmService $saveOrm)
    {
        $this->fileReader = $fileReader;
        $this->saveSql = $saveSql;
        $this->saveOrm = $saveOrm;
    }

    #[Route('', name: 'home', methods: ['GET'])]
    public function home(Request $request): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/showTables', name: 'tables', methods: ['GET'])]
    public function tables(Request $request): Response
    {
        $savesSql = $this->saveSql->getSavesSql();
        $savesOrm = $this->saveOrm->getAllOrmSaves();

        return $this->render('tables.html.twig', [
            'saves_sql' => $savesSql,
            'saves_orm' => $savesOrm,
        ]);
    }



    #[Route('/readFile', name: 'readFile', methods: ['GET'])]
    public function readFile(Request $request): Response
    {
        $filePath = __DIR__ . '/../../data/input.txt';
        $content = $this->fileReader->readFile($filePath);

        $sqlSuccess = $this->saveSql->createSaveSql($content);
        if ($sqlSuccess) {
            $this->addFlash('success', 'Fichier enregistré avec succès dans la base SQL.');
        } else {
            $this->addFlash('error', 'Erreur lors de l’enregistrement dans la base SQL.');
        }

        $ormSuccess = $this->saveOrm->createSaveOrm($content);
        if ($ormSuccess) {
            $this->addFlash('success', 'Fichier enregistré avec succès dans la base ORM.');
        } else {
            $this->addFlash('error', 'Erreur lors de l’enregistrement dans la base ORM.');
        }

        return $this->redirectToRoute('home_home');
    }

}
