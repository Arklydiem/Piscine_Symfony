<?php

    require_once 'HotBeverage.php';
    require_once 'Coffee.php';
    require_once 'Tea.php';
    require_once 'TemplateEngine.php';

    $coffee = new Coffee();
    $tea = new Tea();

    $templateEngine = new TemplateEngine();
    $templateEngine->createFile($coffee);
    $templateEngine->createFile($tea);

?>
