<?php

    class Coffee extends HotBeverage {
        private string $description;
        private string $comment;

        public function __construct() {
            parent::__construct("Coffee", 2.99, 90);
            $this->description = "A rich and bold coffee.";
            $this->comment = "Perfect to start your day.";
        }

        // Getters for the new attributes
        public function getDescription(): string {
            return $this->description;
        }

        public function getComment(): string {
            return $this->comment;
        }
    }

?>