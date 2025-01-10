<?php
class QuestionCheckBox extends Question{

    private $choices = [array()];

    public function __construct(string $name, string $type, string $text, string $answer, int $score){
        parent::__construct($name, $type, $text, $answer, $score);
        $this->choices = [array()];
    }
    public function setChoices(array $choices): void{
        $this->choices = $choices;
    }
    public function getChoices(): array{
        return $this->choices;
    }


}

?>