<?php
namespace Classes;

class QuestionText extends Question{

    public function __construct(string $name, string $type, string $text, string $answer, int $score,int $id, int $value){
        parent::__construct($name, $type, $text, $answer, $score, $id, $value);
    }
    function question_text(): void {
        echo "<br><input type='text' name='" . $this->getName() . "'><br>";
    }

    public function questionRadio(): void {
        $html = $this->getText() . "<br>";
        $i = 0;
        foreach ($this->getChoices() as $choice) {
            $i++;
            $html .= "<input type='radio' name='" . $this->getName() . "' value='" . $choice . "' id='" . $this->getId() . "-$i'>";
            $html .= "<label for='" . $this->getId() . "-$i'>" . $choice . "</label><br>";
        }
        echo $html;
    }
    
    //function answer_text(): void {
    //    //$score_total += $this->getScore();
//
    //    //if (is_null($v)) return;
    //    //if ($this->getAnswer() == $v) {
    //        //$question_correct += 1;
    //        //$score_correct += $this->getScore();
    //    }
    //}

}

?>