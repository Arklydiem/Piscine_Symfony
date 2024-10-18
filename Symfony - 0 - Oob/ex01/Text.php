<?php

class Text {
    private $strings;

    public function __construct($strings = []) {
        $this->strings = $strings;
    }

    public function append($newString) {
        $this->strings[] = $newString;
    }

    public function readData() {
        $htmlOutput = '';
        foreach ($this->strings as $string) {
            $htmlOutput .= "<p>" . htmlspecialchars($string) . "</p>\n";
        }
        return $htmlOutput;
    }
}
