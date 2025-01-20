
<!doctype html>
<html>
<head>
<title>Quiz</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
echo "<div class = 'titre'> <h1>". "Quizz" ."</h1></div>";


// Initialisation -----------------------------------------------------
require_once 'data/questions.php';
require_once 'BD/majBD.php';
session_start(); // Start session

if (!isset($_SESSION['quiz'])) {
    $_SESSION['quiz'] = [];
}
  
function login($pdo): void{
    if (isset($_POST['nom_utilisateur'])){
        insertData($pdo,  1, $_POST['nom_utilisateur'], 0);
        echo "Bienvenue " . $_POST['nom_utilisateur']."!!".PHP_EOL;
    }
}
function logout(): void{
    echo "Vous êtes déconnecté.";
}

affichageJoueur($pdo,id: 5);
login($pdo);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'autoload.php';

// Register the autoloader
spl_autoload_register(['Autoloader', 'loadClass']);

use Classes\QuestionRadio;
use Classes\QuestionCheckBox;
use Classes\QuestionText;

// Logic ------------------------------------------------------------
$questions = getQuestions();
$question_handlers = array(
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "<form method='POST' action='templates/Deconnexion.php'><ol>";
    echo "</ol><input type='submit' value='Se déconnecter'></form>";

    echo "<form method='POST' action='templates/FormConnexion.php'><ol>";
    echo "</ol><input type='submit' value='Se connecter'></form>";

    echo "<form method='POST' action='templates/quiz.php'><ol>";

    foreach ($questions as $q) {
        echo "<li>";
        $question_handlers[$q["type"]]($q);
    }
    echo "<input type='submit' value='Envoyer'></form>";
}

$question_total = 0;
$question_correct = 0;
$score_total = 0;
$score_correct = 0;

function question_text($q) {
    $questionText =  new QuestionText("Text", "Text", $q["label"], $q["correct"], 2, $q["uuid"],3);
    $questionText->questionText();
}

function answer_text($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}

function question_radio($q) {
    $questionRadio = new QuestionRadio($q["uuid"], "radio", $q["label"], $q["correct"], 1, $q["uuid"],"radio1");
    $questionRadio->setChoices($q["choices"]);
    $questionRadio->questionRadio();


}

function answer_radio($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}

function question_checkbox($q) {
    $questionCheckBox  = new QuestionCheckBox("checkBox", "checkBox", $q["label"], $q["correct"][0], 2, $q["uuid"],"checkBox");
    $questionCheckBox->setChoices($q["choices"]);
    $questionCheckBox->questionCheckBox();

}

function answer_checkbox($q, $v) {
    global $question_correct, $score_total, $score_correct;
    $score_total += $q["score"];
    if (is_null($v)) return;
    $diff1 = array_diff($q["answer"], $v);
    $diff2 = array_diff($v, $q["answer"]);
    if (count($diff1) == 0 && count($diff2) == 0) {
        $question_correct += 1;
        $score_correct += $q["score"];
    }
}


$answer_handlers = array(
    "text" => "answer_text",
    "radio" => "answer_radio",
    "checkbox" => "answer_checkbox"
);

#if ($_SERVER["REQUEST_METHOD"] == "GET") {
#    echo "<form method='POST' action='templates/Deconnexion.php'><ol>";
#    echo "</ol><input type='submit' value='Se déconnecter'></form>";
#
#    echo "<form method='POST' action='templates/FormConnexion.php'><ol>";
#    echo "</ol><input type='submit' value='Se connecter'></form>";
#    echo "<form method='POST' action='templates/quiz.php'><ol>";
#
#    foreach ($questions_bis as $q) {
#        echo "<li>";
#        $question_handlers[$q["type"]]($q);
#    }
#    echo "</ol><input type='submit' value='Envoyer'></form>";
#} else {
#    $question_total = 0;
#    $question_correct = 0;
#    $score_total = 0;
#    $score_correct = 0;
#    foreach ($questions as $q) {
#        $question_total += 1;
#        $answer_handlers[$q["type"]]($q, $_POST[$q["name"]] ?? NULL);
#    }
#    echo "Réponses correctes: " . $question_correct . "/" . $question_total . "<br>";
#    echo "Votre score: " . $score_correct . "/" . $score_total . "<br>";
#}

?>
</body>
</html>

