<?php
    $filePath = 'ex01.txt';
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $values = explode(',', $content);
        foreach ($values as $value) {
            echo trim($value) . "\n";
        }
    }
?>