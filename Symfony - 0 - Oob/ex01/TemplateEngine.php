<?php

class TemplateEngine {
    public function createFile($fileName, Text $text) {
        $htmlContent =
            "<!DOCTYPE html>" . "\n" .
            "<html lang=\"en\">" . "\n" .
            "<head>" . "\n" .
	        "\t" . "<meta charset=\"UTF-8\">" . "\n" .
	        "\t" . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">" . "\n" .
	        "\t" . "<title>Document</title>" . "\n" .
            "</head>" . "\n" .
            "<body>" . "\n";
        $htmlContent .= $text->readData();
        $htmlContent .= "</body>" . "\n" . "</html>";
        file_put_contents($fileName, $htmlContent);
    }
}
?>