<?php
    class TemplateEngine {
        public function createFile($fileName, $templateName, $parameters) {
            $templateContent = file_get_contents($templateName);
            
            foreach ($parameters as $key => $value) {
                $templateContent = str_replace('{' . $key . '}', $value, $templateContent);
            }
            
            file_put_contents($fileName, $templateContent);
        }
    }
?>