<?php

require_once "MyException.php";

    class Elem {
        private $element;
        private array $content;
        private array $attributes;
        private $selfClosingTags = ['meta', 'img', 'hr', 'br'];
        private $allowedTags = ['meta', 'img', 'hr', 'br', 'html', 'head', 'body', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div', 'table', 'tr', 'th', 'td', 'ul', 'ol', 'li'];

        public function __construct($element, $content = [], $attribute = []) {
            if (!in_array($element, $this->allowedTags)) {
                throw new MyException("Unauthorized HTML tag: $element");
            }
            $this->element = $element;
            $this->content = is_array($content) ? $content : [$content];
            $this->attributes = $attribute;
        }

        public function pushElement(Elem $elem) {
            $this->content[] = $elem;
        }

        public function getHTML($indentationLevel = 0) {
            if (in_array($this->element, $this->selfClosingTags)) {
                return $this->fillIdentation($indentationLevel) . "<{$this->element}" . $this->fillAttributes() . ">" . PHP_EOL;
            } else {
                $html = $this->fillIdentation($indentationLevel) . "<{$this->element}" . $this->fillAttributes() . ">";
                foreach ($this->content as $index => $item) {
                    if ($item instanceof Elem) {
                        if ($index < 1)
                            $html .= PHP_EOL;
                        $html .= $item->getHTML(1 + $indentationLevel);
                    } else {
                        $html .= $item;
                    }
                }
                if (count($this->content) >= 1 && $this->content[0] instanceof Elem)
                    $html .= $this->fillIdentation($indentationLevel);
                $html .= "</{$this->element}>" . PHP_EOL;
                return $html;
            }
        }

        private function fillAttributes() {
            $html = "";
            foreach ($this->attributes as $key => $value) {
                $html .= " " . $key . "=\"" . $value . "\"";
            }
            return $html;
        }

        private function fillIdentation($indentationLevel) {
            return str_repeat("\t", $indentationLevel);
        }
    }

?>
