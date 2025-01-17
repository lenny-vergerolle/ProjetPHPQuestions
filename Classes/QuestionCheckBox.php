<?php
namespace Classes;
class QuestionCheckBox extends Question{

    private $choices = [array()];

    public function __construct(string $name, string $type, string $text, string $answer, int $score,$id,$value){
        parent::__construct($name, $type, $text, $answer, $score, $id,$value);
        $this->choices = [array()];
    }
    public function setChoices(array $choices): void{
        $this->choices = $choices;
    }
    public function getChoices(): array{
        return $this->choices;
    }

    public function questionCheckBox(): void {
        $html = $this->getText() . "<br>";
        $i = 0;
        foreach ($this->getChoices() as $choice) {
            $i++;
            $html .= "<input type='checkbox' name='" . $this->getName() . "' value='" . $choice . "' id='" . $this->getId() . "-$i'>";
            $html .= "<label for='" . $this->getId() . "-$i'>" . $choice . "</label><br>";
        }
        echo $html;
    }


}

?>