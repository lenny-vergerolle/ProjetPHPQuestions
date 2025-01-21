<?php
namespace Classes;

class QuestionRadio extends Question {
    private array $choices;

    public function __construct(string $name, string $type, string $text, string $answer, int $score, String $id, string $value) {
        parent::__construct($name, $type, $text, $answer, $score,$id,$value );
        $this->choices = [];
    }

    public function getChoices(): array {
        return $this->choices;
    }

    public function setChoices(array $choices): void {
        $this->choices = $choices;
    }

    public function questionRadio(): void {
        $html = $this->getText() . "<br>";
        $i = 0;
        foreach ($this->getChoices() as $choice) {
            $i++;
            $html .= "<input type='radio' name=quiz[name][Question". $i ."] value='" . $choice . "' id='quiz[name][" . $this->getId() . "-$i]'>";
            $html .= "<label for='quiz[name][" . $this->getId() . "-$i]'>" . $choice . "</label><br>";
            // $html .= "<input type='hidden' name='quiz['".$this->getId(). "-$i" . "']' value='" . htmlspecialchars($choice) . "'> " . htmlspecialchars($choice) . "</label><br>";
        }
        echo $html;
    }
}
