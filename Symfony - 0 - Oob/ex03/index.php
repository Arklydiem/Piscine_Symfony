<?php
require_once 'TemplateEngine.php';
require_once 'Elem.php';

$html = new Elem('html');

$head = new Elem('head');
$head->pushElement(new Elem('title', 'Mon site web'));

$body = new Elem('body');
$body->pushElement(new Elem('h1', 'Bienvenue sur mon site'));
$body->pushElement(new Elem('p', 'Ceci est un paragraphe de test.'));

$html->pushElement($head);
$html->pushElement($body);

$templateEngine = new TemplateEngine($html);
$templateEngine->createFile('output.html');
?>
