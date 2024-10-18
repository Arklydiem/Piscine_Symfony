<?php

    class Tea extends HotBeverage {
        private string $description;
        private string $comment;

        public function __construct() {
            parent::__construct("Tea", 1.99, 85);
            $this->description = "A soothing and calming tea.";
            $this->comment = "Ideal for relaxation.";
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