
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
require_once 'autoload.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start(); // Start session


// Register the autoloader
spl_autoload_register(['Autoloader', 'loadClass']);

use Classes\QuestionRadio;
use Classes\QuestionCheckBox;
use Classes\QuestionText;
use BD\majBD;


$majBD = new MajBD();

$majBD -> afficheJoueur(id: 5);

$_SESSION['user_id'] = [];

function login(): void {
    global $majBD;
    if (isset($_POST['nom_utilisateur'])) {
        $name = $_POST['nom_utilisateur'];
        $newPlayerId = $majBD->insertData(name: $name);
        $_SESSION['user_id'] = $newPlayerId;
        echo "Bienvenue " . $name . "!!" . PHP_EOL;
    }
}


login();



if (!isset($_SESSION['quiz'])) {
    $_SESSION['quiz'] = [];

}


function logout(): void{
    session_start();
    session_unset();
    session_destroy();
    echo "Vous êtes déconnecté.";
}



// Logic ------------------------------------------------------------
$questions = getQuestions();
$question_handlers = array(
    "text" => "question_text",
    "radio" => "question_radio",
    "checkbox" => "question_checkbox"
);
$answer_handlers = array(
    "text" => "answer_text",
    "radio" => "answer_radio",
    "checkbox" => "answer_checkbox"
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
}else {
    global $majBD;
    $id = $_SESSION['user_id'];
    foreach ($questions as $q) {
        $majBD->incrementeQuestionsTotal();
        $answer_handlers[$q["type"]]($q, $_POST[$q["nom_utilisateur"]] ?? NULL);
    }
    $majBD->afficheJoueur(id: $id);
}
function question_text($q) {
    $questionText =  new QuestionText("Text", "Text", $q["label"], $q["correct"], 2, $q["uuid"],3);
    $questionText->questionText();
}
function answer_text($q, $v) {
    global $majBD;
    $id = $_SESSION['user_id'];
    $majBD->incrementeScoreTotal($id,$q["score"]);
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $majBD->incrementeQuestionCorrect($id);
        $majBD->incrementeScoreCorrect($id,$q["score"]);
    }
}
function question_radio($q) {
    $questionRadio = new QuestionRadio("name", "radio", $q["label"], $q["correct"], 1, $q["uuid"],"radio1");
    $questionRadio->setChoices($q["choices"]);
    $questionRadio->questionRadio();
}
function answer_radio($q, $v) {
    global $majBD;
    $id = $_SESSION['user_id'];
    $majBD->incrementeScoreTotal($id,$q["score"]);
    if (is_null($v)) return;
    if ($q["answer"] == $v) {
        $majBD->incrementeQuestionCorrect($id);
        $majBD->incrementeScoreCorrect($id,$q["score"]);
    }
}
function question_checkbox($q) {
    $questionCheckBox  = new QuestionCheckBox("checkBox", "checkBox", $q["label"], $q["correct"][0], 2, $q["uuid"],"checkBox");
    $questionCheckBox->setChoices($q["choices"]);
    $questionCheckBox->questionCheckBox();
}

function answer_checkbox($q, $v) {
    global $majBD;
    $id = $_SESSION['user_id'];
    $majBD->incrementeScoreTotal($id,$q["score"]);
    if (is_null($v)) return;
    $diff1 = array_diff($q["answer"], $v);
    $diff2 = array_diff($v, $q["answer"]);
    if (count($diff1) == 0 && count($diff2) == 0) {
        $majBD->incrementeQuestionCorrect($id);
        $majBD->incrementeScoreCorrect($id,$q["score"]);
    }
}


?>
</body>
</html>

