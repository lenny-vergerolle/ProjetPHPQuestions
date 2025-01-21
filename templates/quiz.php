<?php

session_start();

require_once "../data/questions.php";

require_once '../autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(callback: ['Autoloader', 'loadClass']);

use Classes\QuestionRadio;
use Classes\QuestionCheckBox;
use Classes\QuestionText;
use BD\MajBD;

if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    // Supprimez les variables spécifiques de la session
    unset($_SESSION['quiz_results']);
    unset($_SESSION['reponses']);
    unset($_SESSION['bonne_reponses']);

    // Redirigez vers la page du quiz sans le paramètre "reset"
    header('Location: quiz.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$majBD = new MajBD();

// Définition des handlers
$question_handlers = [
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
];
$answer_handlers = [
    "text" => "answer_text",
    "radio" => "answer_radio",
    "checkbox" => "answer_checkbox"
];

// Définition des fonctions handlers
function question_text($q) {
    //Afficher une question de type texte
    
    $questionText = new QuestionText($q["uuid"], "Text", $q["label"], $q["answer"], 2, $q["uuid"], 3);
    $questionText->questionText();
}

function question_radio($q) {
    //Afficher une question de type radio
    $questionRadio = new QuestionRadio($q["uuid"], "radio", $q["label"], $q["answer"], 1, $q["uuid"], "radio1");
    $questionRadio->setChoices($q["choices"]);
    $questionRadio->questionRadio();
}

function question_checkbox($q) {
    
    //Afficher une question de type checkbox
    
    $questionCheckBox = new QuestionCheckBox($q["uuid"], "checkbox", $q["label"], $q["answer"][0], 2, $q["uuid"], "checkBox");
    $questionCheckBox->setChoices($q["choices"]);
    $questionCheckBox->questionCheckBox();
}
function answer_radio($q, $v, $majBD, $userId): bool {
   
    //Répondre à une question de type radio
    
    if ($v !== null) {
        $majBD->incrementeScoreTotal($userId, $q['score']);
        if ($v == $q['answer']) {
            $majBD->incrementeQuestionCorrect($userId);
            $majBD->incrementeScoreCorrect($userId, $q['score']);
            return true;
        }
    }
    return false;
}
function answer_checkbox($q, $v, $majBD, $userId): bool {
    
    //Répondre à une question de type checkbox
    
    if (is_array($v) && !empty($v)) {
        $majBD->incrementeScoreTotal($userId, $q['score']);
        $correctAnswers = $q['answer']; 
        sort(array: $v);
        sort(array: $correctAnswers);

        if ($v === $correctAnswers) {
            $majBD->incrementeQuestionCorrect($userId);
            $majBD->incrementeScoreCorrect($userId, $q['score']);
            return true;
        }
    }
    return false;
}

function answer_text($q, $v, $majBD, $userId): bool {
    
    //Répondre à une question de type texte
    
    if ($v !== null) {
        $majBD->incrementeScoreTotal($userId, $q['score']);
        
        if (strtolower(string: $v) == strtolower(string: $q['answer'])) {
            $majBD->incrementeQuestionCorrect($userId);
            $majBD->incrementeScoreCorrect($userId, $q['score']);
            return true;
        }
    }
    return false;
}


// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $correct_answers = 0;

    $questions = getQuestions();

    foreach ($questions as $question) {
        $answer = $question['type'] === 'checkbox' ? ($_POST[$question['uuid']] ?? []) : ($_POST[$question['uuid']] ?? null);
        $handler = $answer_handlers[$question['type']];
        $_SESSION['reponses'][] = $answer;
        $_SESSION['bonne_reponses'][] = $question['answer'];

        if ($handler($question, $answer, $majBD, $_SESSION['user_id'])) {
            $majBD -> incrementeQuestionsTotal($_SESSION['user_id']);
            $correct_answers++;
        }
    }
    $_SESSION['quiz_results'] = [
        'correct_answers' => $correct_answers,
        'total_questions' => count($questions)
    ];

    header('Location: results.php');
    exit;
}

// Chargement des questions pour l'affichage
$questions = getQuestions();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <form method="POST" action="logout.php">
        <button class ="button" type="submit">Se déconnecter</button>
    </form>
    <div class="titre">
        <h1>Quizz</h1>
        <p class="bienvenue">Bienvenue <?php echo htmlspecialchars($_SESSION['user_name']); ?> !!!</p>
    </div>

    <form method="POST" action="">
        <ol>
        <?php foreach ($questions as $q): ?>
            <li>
                <?php
                $handler = $question_handlers[$q['type']];
                $handler($q);
                ?>
            </li>
        <?php endforeach; ?>
        </ol>
        <button class="button" type="submit" name="submit_quiz">Valider les réponses</button>
    </form>

    
</body>
</html>
