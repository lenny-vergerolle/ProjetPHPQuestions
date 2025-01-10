<?php

class QuestionText extends Question{

    public function __construct(string $name, string $type, string $text, string $answer, int $score){
        parent::__construct($name, $type, $text, $answer, $score);
    }
    function question_text(): void {
        echo "<br><input type='text' name='" . $this->getName() . "'><br>";
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