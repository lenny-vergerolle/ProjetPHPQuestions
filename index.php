
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
session_start(); // Start session

if (!isset($_SESSION['quiz'])) {
    $_SESSION['quiz'] = [];
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'autoload.php';

// Register the autoloader
spl_autoload_register(['Autoloader', 'loadClass']);

use Classes\QuestionRadio;
use Classes\QuestionCheckBox;
use Classes\QuestionText;


#$questionRadio = new QuestionRadio("Bouton", "Radio", "la question", "réponses", 1,1,"valeur");
#$questionRadio->setChoices(['Option 1', 'Option 2', 'Option 3']);
#$questionRadio->questionRadio();
#
#$questionCheckBox  = new QuestionCheckBox("checkBox", "checkBox", "Le checkBox", "bonne réponse", 2, 2,"valeur");
#$questionCheckBox->setChoices(['Option 1', 'Option 2', 'Option 3']);
#$questionCheckBox->questionCheckBox();
#
#$questionText =  new QuestionText("Text", "Text", "Quel est la bonne réponsej", "bonne réponse", 2, 2,3);


// Logic ------------------------------------------------------------
$questions_bis = getQuestions();

echo "<form method='POST' action='templates/quiz.php'>";
foreach ($questions_bis as $key => $question) {
    if ($question['type'] == 'radio'){

        $questionRadio = new QuestionRadio($key, "radio", $question["label"], $question["correct"], 1, $question["uuid"],"radio1");
        $questionRadio->setChoices($question["choices"]);
        $questionRadio->questionRadio();

    }

}

echo "<input type='submit' value='Envoyer'></form>";

$questions = [
    array(
        "name" => "ultime",
        "type" => "text",
        "text" => "Quelle est la réponse ultime?",
        "answer" => "42",
        "score" => 1
    ),
    array(
        "name" => "cheval",
        "type" => "radio",
        "text" => "Quelle est la couleur du cheval blanc d'Henri IV?",
        "choices" => [
            array(
                "text" => "Bleu",
                "value" => "bleu"),
            array(
                "text" => "Blanc",
                "value" => "blanc"),
            array(
                "text" => "Rouge",
                "value" => "rouge"),
        ],
        "answer" => "blanc",
        "score" => 2
    ),
    array(
        "name" => "drapeau",
        "type" => "checkbox",
        "text" => "Quelles sont les couleurs du drapeau français?",
        "choices" => [
            array(
                "text" => "Bleu",
                "value" => "bleu"
            ),
            array(
                "text" => "Blanc",
                "value" => "blanc"
            ),
            array(
                "text" => "Vert",
                "value" => "vert"
            ),
            array(
                "text" => "Jaune",
                "value" => "jaune"
            ),
            array(
                "text" => "Rouge",
                "value" => "rouge"
            )
        ],
        "answer" => ["bleu", "blanc", "rouge"],
        "score" => 3
    ),
];

$question_total = 0;
$question_correct = 0;
$score_total = 0;
$score_correct = 0;

function question_text($q) {
    echo ($q["text"] . "<br><input type='text' name='$q[name]'><br>");
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
    $html = $q["text"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='radio' name='$q[name]' value='$c[value]' id='$q[name]-$i'>";
        $html .= "<label for='$q[name]-$i'>$c[text]</label>";
    }
    echo $html;
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
    $html = $q["text"] . "<br>";
    $i = 0;
    foreach ($q["choices"] as $c) {
        $i += 1;
        $html .= "<input type='checkbox' name='$q[name][]' value='$c[value]' id='$q[name]-$i'>";
        $html .= "<label for='$q[name]-$i'>$c[text]</label>";
    }
    echo $html;
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
    echo "<form method='POST' action='templates/quiz.php'><ol>";
    foreach ($questions as $q) {
        echo "<li>";
        $question_handlers[$q["type"]]($q);
    }
    echo "</ol><input type='submit' value='Envoyer'></form>";
} else {
    $question_total = 0;
    $question_correct = 0;
    $score_total = 0;
    $score_correct = 0;
    foreach ($questions as $q) {
        $question_total += 1;
        $answer_handlers[$q["type"]]($q, $_POST[$q["name"]] ?? NULL);
    }
    echo "Réponses correctes: " . $question_correct . "/" . $question_total . "<br>";
    echo "Votre score: " . $score_correct . "/" . $score_total . "<br>";
}

?>
</body>
</html>

