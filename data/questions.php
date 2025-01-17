<?php

function getQuestions(): array|Exception
{
    $source = 'data/model.json';
    $content = file_get_contents($source);
    $questions = json_decode($content, true);

    if (empty($questions)) {
        throw new Exception('Pas de questions:(', 1);
    }

    return $questions;
}


?>