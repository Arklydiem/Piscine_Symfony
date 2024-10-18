<?php

require_once 'TemplateEngine.php';
require_once 'Elem.php';

    $elem = new Elem('html');
    $body = new Elem('body');
    $body->pushElement(new Elem('p', 'Lorem ipsum', ['class' => 'text-muted']));
    $elem->pushElement($body);

    $templateEngine = new TemplateEngine($elem);
    $templateEngine->createFile('output.html');

    $elem = new Elem('ykyj');
?>
