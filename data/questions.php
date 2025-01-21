<?php

function getQuestions(): array|Exception
{
    $source = '../data/model.json';
    if (!file_exists($source)) {
        throw new Exception('Le fichier de questions est introuvable.', 1);
    }
    $content = file_get_contents($source);
    if ($content === false) {
        throw new Exception('Erreur lors de la lecture du fichier de questions.', 2);
    }
    $questions = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erreur lors du décodage JSON: ' . json_last_error_msg(), 3);
    }

    if (empty($questions)) {
        throw new Exception('Pas de questions :(', 4);
    }

    return $questions;
}

?>