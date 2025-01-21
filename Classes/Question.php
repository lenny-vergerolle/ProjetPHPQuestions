<?php
namespace Classes;
abstract class Question{
    private String $id;
    private string $value ;
    private string $name;
    private string $type;
    private string $text;
    private string $answer;
    private int $score;
    public function __construct(string $name, string $type, string $text, string $answer, int $score, String $id,string $value){
        $this->name = $name;
        $this->type = $type;
        $this->text = $text;
        $this->answer = $answer;
        $this->score = $score;
        $this->id = $id;
        $this->value = $value;
        }

    public function getId(): String
    {
        return $this->id;
    }
    public function setId(String $id): void
    {
        $this->id = $id;
    }
    public function getValue(): string
    {
        return $this->value;
    }
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
    
    public function getAnswer(): string
    {
        return $this->answer;
    }
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
    public function getScore(): int
    {
        return $this->score;
    }
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
    public function __toString(): string
    {
        return $this->name . " " . $this->type . " " . $this->text;
    }


}

?>