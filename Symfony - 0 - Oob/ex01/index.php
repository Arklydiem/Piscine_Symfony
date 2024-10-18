<?php

require 'TemplateEngine.php';
require 'Text.php';

$templateEngine = new TemplateEngine();

$text = new Text(['Ceci est le premier paragraphe.', 'Voici un deuxième paragraphe.']);
$text->append('Un troisième paragraphe ajouté.');

$templateEngine->createFile('book_description.html', $text);

?>