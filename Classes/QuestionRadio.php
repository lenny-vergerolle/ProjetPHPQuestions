<?php  

global $question_correct, $score_total, $score_correct;
class QuestionRadio extends Question{
    private $choices = [array()];

    public function __construct(string $name, string $type, string $text, string $answer, int $score){
        parent::__construct($name, $type, $text, $answer, $score);
        $this->choices = [array()];
    }

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

    function question_radio() {
        $html = $this -> getText() . "<br>";
        $i = 0;
        foreach ($this->getChoices() as $choice) {
            $i += 1;
            $html .= "<input type='radio' name='" . $this->getName() . "' value='".$this->getValue()."' id='".$this->getId()."-$i'>";
            $html .= "<label for='".$this->getId()."-$i'>$this -> getText()</label>";
        }
        echo $html;
    }
    
    function answer_radio() {
        //$score_total += $this->getScore();
        //if (is_null($v)) return;
        //if ($q["answer"] == $v) {
        //    $question_correct += 1;
        //    $score_correct += $q["score"];
        //}
    }
}

?>