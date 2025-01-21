<?php
namespace Classes;

class QuestionText extends Question {

    public function __construct(string $name, string $type, string $text, string $answer, int $score, string $id, int $value) {
        parent::__construct($name, $type, $text, $answer, $score, $id, $value);
    }

    public function questionText(): void {
        $html = "<label for='" . $this->getId() . "'>" . $this->getText() . "</label><br>";
        $html .= "<input type='text' name='" . $this->getName() . "' id='" . $this->getId() . "' value='' required><br>";
        echo $html;
    }
}


?>