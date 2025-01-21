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
    $questionText = new QuestionText($q["uuid"], "Text", $q["label"], $q["answer"], 2, $q["uuid"], 3);
    $questionText->questionText();
}

function question_radio($q) {
    $questionRadio = new QuestionRadio($q["uuid"], "radio", $q["label"], $q["answer"], 1, $q["uuid"], "radio1");
    $questionRadio->setChoices($q["choices"]);
    $questionRadio->questionRadio();
}

function question_checkbox($q) {
    $questionCheckBox = new QuestionCheckBox($q["uuid"], "checkbox", $q["label"], $q["answer"][0], 2, $q["uuid"], "checkBox");
    $questionCheckBox->setChoices($q["choices"]);
    $questionCheckBox->questionCheckBox();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $correct_answers = 0;
    $questions = getQuestions();

    foreach ($questions as $question) {
        $answer = $question['type'] === 'checkbox' ? ($_POST[$question['uuid']] ?? []) : ($_POST[$question['uuid']] ?? null);
        $handler = $answer_handlers[$question['type']];

        if ($handler($question, $answer, $majBD, $_SESSION['user_id'])) {
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
    <div class="titre">
        <h1>Quiz</h1>
        <p>Bienvenue <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
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
        <button type="submit" name="submit_quiz">Valider les réponses</button>
    </form>

    <form method="POST" action="logout.php">
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>
