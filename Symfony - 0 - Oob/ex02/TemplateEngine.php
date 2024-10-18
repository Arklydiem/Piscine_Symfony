<?php

    class TemplateEngine {
        public function createFile(HotBeverage $beverage) {
            $class = new ReflectionClass($beverage);
            $className = $class->getShortName();
            $properties = $class->getProperties();

            $template = file_get_contents('template.html');

            $template = str_replace("{nom}", $className, $template);
            
            foreach ($properties as $property) {
                $getter = 'get' . ucfirst($property->getName());
                if (method_exists($beverage, $getter)) {
                    $value = $beverage->$getter();
                    $template = str_replace("{" . $property->getName() . "}", $value, $template);
                }
            }

            file_put_contents($className . '.html', $template);
        }
    }

?>