<?php
    require './TemplateEngine.php';

    $templateEngine = new TemplateEngine();

    $parameters = [
        'nom' => 'Mon Livre',
        'auteur' => 'John Doe',
        'description' => 'Ceci est un livre d\'exemple.',
        'prix' => '19.99'
    ];

    $templateEngine->createFile('BiographieJohnDoe.html', 'book_description.html', $parameters);
?>