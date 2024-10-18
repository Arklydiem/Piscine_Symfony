<?php

// Include the custom exception class for handling errors
require_once "MyException.php";

// Class representing an HTML element
class Elem {
    // Properties for storing element tag, content, attributes, and allowed/self-closing tags
    private $element; // The HTML tag of the element (e.g., 'div', 'p', etc.)
    private array $content; // The content inside the element (could be strings or other Elem objects)
    private array $attributes; // Array of HTML attributes (e.g., class, id)
    private $selfClosingTags = ['meta', 'img', 'hr', 'br']; // List of tags that are self-closing
    private $allowedTags = ['meta', 'img', 'hr', 'br', 'html', 'head', 'body', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div', 'table', 'tr', 'th', 'td', 'ul', 'ol', 'li']; // List of allowed HTML tags

    // Constructor to initialize an element with its tag, content, and attributes
    public function __construct($element, $content = [], $attribute = []) {
        // Check if the tag is in the allowed list, throw an exception if not
        if (!in_array($element, $this->allowedTags)) {
            throw new MyException("Unauthorized HTML tag: $element");
        }
        // Initialize element, content, and attributes (content is an array)
        $this->element = $element;
        $this->content = is_array($content) ? $content : [$content];
        $this->attributes = $attribute;
    }

    // Method to add (push) another Elem object as a child to this element's content
    public function pushElement(Elem $elem) {
        $this->content[] = $elem;
    }

    // Method to generate the HTML for the element and its content recursively
    public function getHTML($indentationLevel = 0) {
        // Check if the element is self-closing
        if (in_array($this->element, $this->selfClosingTags)) {
            // Return self-closing tag with proper indentation and attributes
            return $this->fillIdentation($indentationLevel) . "<{$this->element}" . $this->fillAttributes() . ">" . PHP_EOL;
        } else {
            // Open the HTML tag with attributes
            $html = $this->fillIdentation($indentationLevel) . "<{$this->element}" . $this->fillAttributes() . ">";
            // Loop through the content (strings or Elem objects)
            foreach ($this->content as $index => $item) {
                // If the content is another Elem object, recursively get its HTML with increased indentation
                if ($item instanceof Elem) {
                    if ($index < 1)
                        $html .= PHP_EOL; // Add a newline after the opening tag if there's at least one child Elem
                    $html .= $item->getHTML(1 + $indentationLevel);
                } else {
                    // For string content, append it directly
                    $html .= $item;
                }
            }
            // If content includes other Elem objects, close the tag with proper indentation
            if (count($this->content) >= 1 && $this->content[0] instanceof Elem)
                $html .= $this->fillIdentation($indentationLevel);
            // Close the tag
            $html .= "</{$this->element}>" . PHP_EOL;
            return $html;
        }
    }

    // Helper function to generate the HTML attributes as a string
    private function fillAttributes() {
        $html = "";
        // Loop through each attribute and append it in 'key="value"' format
        foreach ($this->attributes as $key => $value) {
            $html .= " " . $key . "=\"" . $value . "\"";
        }
        return $html;
    }

    // Helper function to handle indentation for the HTML output (using tabs)
    private function fillIdentation($indentationLevel) {
        return str_repeat("\t", $indentationLevel);
    }

    // Method to validate if the structure of the element is a valid HTML page
    public function validPage() {
        // Check if the root element is 'html'
        if ($this->element !== 'html') {
            return false;
        }

        // Variables to track if 'head' and 'body' are present, and their positions
        $hasHead = false;
        $hasBody = false;
        $headIndex = -1;
        $bodyIndex = -1;

        // Iterate through the root's children to check for 'head' and 'body' tags
        foreach ($this->content as $index => $child) {
            if ($child instanceof Elem) {
                // Check if there's exactly one 'head' element
                if ($child->element === 'head') {
                    if ($hasHead) return false; // More than one 'head' is invalid
                    $hasHead = true;
                    $headIndex = $index;
                }
                // Check if there's exactly one 'body' element
                if ($child->element === 'body') {
                    if ($hasBody) return false; // More than one 'body' is invalid
                    $hasBody = true;
                    $bodyIndex = $index;
                }
            }
        }

        // Ensure both 'head' and 'body' are present, and 'head' comes before 'body'
        if (!($hasHead && $hasBody && $headIndex < $bodyIndex)) {
            return false;
        }

        $hasTitle = false;
        $hasMetaCharset = false;

        // Validate that 'head' contains exactly one 'title' and one 'meta charset'
        foreach ($this->content[$headIndex]->content as $child) {
            if ($child instanceof Elem) {
                if ($child->element === 'meta' && isset($child->attributes['charset'])) {
                    if ($hasMetaCharset) return false; // More than one meta with charset
                    $hasMetaCharset = true;
                }
                if ($child->element === 'title') {
                    if ($hasTitle) return false; // More than one title
                    $hasTitle = true;
                }
            }
        }

        // Ensure both title and meta charset exist
        if (!$hasTitle || !$hasMetaCharset) {
            return false; // Missing title or meta charset
        }


        // Ensure that 'p' tags inside 'body' only contain text (no nested elements)
        foreach ($this->content[$bodyIndex]->content as $child) {
            if ($child instanceof Elem && $child->element === 'p') {
                foreach ($child->content as $pContent) {
                    if ($pContent instanceof Elem) {
                        return false; // 'p' tag should not contain other elements
                    }
                }
            }
        }

        // Ensure proper structure for 'table' tags: Only 'tr' allowed inside, and 'tr' only contains 'th' or 'td'
        foreach ($this->content[$bodyIndex]->content as $child) {
            if ($child instanceof Elem && $child->element === 'table') {
                foreach ($child->content as $tableContent) {
                    if ($tableContent instanceof Elem && $tableContent->element !== 'tr') {
                        return false; // Only 'tr' allowed inside 'table'
                    }
                    foreach ($tableContent->content as $trContent) {
                        if ($trContent instanceof Elem && !in_array($trContent->element, ['th', 'td'])) {
                            return false; // Only 'th' or 'td' allowed inside 'tr'
                        }
                    }
                }
            }
        }

        // Validate that 'ul' and 'ol' lists only contain 'li' elements
        foreach ($this->content[$bodyIndex]->content as $child) {
            if ($child instanceof Elem && in_array($child->element, ['ul', 'ol'])) {
                foreach ($child->content as $listContent) {
                    if ($listContent instanceof Elem && $listContent->element !== 'li') {
                        return false; // Only 'li' allowed inside 'ul' or 'ol'
                    }
                }
            }
        }

        // If all validations pass, return true
        return true;
    }
}

?>
