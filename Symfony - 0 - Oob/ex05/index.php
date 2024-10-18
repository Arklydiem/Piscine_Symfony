<?php

require_once 'TemplateEngine.php';
require_once 'Elem.php';

// Create the root 'html' element
$elem = new Elem('html');

// Create the 'head' element
$head = new Elem('head');
$meta = new Elem('meta', [], ['charset' => 'UTF-8']); // meta with charset
$title = new Elem('title', 'My Page'); // title of the page
$head->pushElement($meta);
$head->pushElement($title);

// Create the 'body' element
$body = new Elem('body');

// Create a 'p' element with only text inside (no nested elements)
$p = new Elem('p', 'Lorem ipsum', ['class' => 'text-muted', 'style' => 'color:red;']);

// Create a 'table' element with rows and data cells
$table = new Elem('table');
$tr = new Elem('tr');
$tr->pushElement(new Elem('td', 'Data 1')); // td inside tr
$tr->pushElement(new Elem('td', 'Data 2')); // td inside tr
$table->pushElement($tr);

// Create an unordered list (ul) with list items (li)
$ul = new Elem('ul');
$ul->pushElement(new Elem('li', 'Item 1'));
$ul->pushElement(new Elem('li', 'Item 2'));

// Create an ordered list (ol) with list items (li)
$ol = new Elem('ol');
$ol->pushElement(new Elem('li', 'First'));
$ol->pushElement(new Elem('li', 'Second'));

// Add the 'p', 'table', 'ul', and 'ol' to the 'body' element
$body->pushElement($p);
$body->pushElement($table);
$body->pushElement($ul);
$body->pushElement($ol);

// Add 'head' and 'body' to the root 'html' element
$elem->pushElement($head);
$elem->pushElement($body);

// Check the validity of the page structure and display the result
if ($elem->validPage()) {
    echo "Valid HTML" . PHP_EOL;
} else {
    echo "Invalid HTML" . PHP_EOL;
}

// Use TemplateEngine to create the output HTML file
$templateEngine = new TemplateEngine($elem);
$templateEngine->createFile('output.html');

?>
