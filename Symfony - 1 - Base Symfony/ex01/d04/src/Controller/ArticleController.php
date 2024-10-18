<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class ArticleController extends AbstractController
    {
        private $articles = [
            'gull' => 'This is an article about seagulls.',
            'lion' => 'This is an article about lions.',
            'ocean' => 'This is an article about the ocean.',
        ];

        #[Route('/e01', name: 'main_page')]
        public function mainPage(): Response
        {
            // Pass the list of articles to the template for rendering links
            return $this->render('articles/main.html.twig', [
                'articles' => array_keys($this->articles),
            ]);
        }

        #[Route('/e01/{category}', name: 'article_page')]
        public function articlePage(string $category): Response
        {
            if (!array_key_exists($category, $this->articles)) {
                // If the article doesn't exist, render the main page
                return $this->redirectToRoute('main_page');
            }

            // Render the specific article page
            return $this->render('articles/article.html.twig', [
                'category' => $category,
                'content' => $this->articles[$category],
            ]);
        }
    }
?>