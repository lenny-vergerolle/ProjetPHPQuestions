<?php
session_start();

if (!isset($_SESSION['quiz_results'])) {
    header('Location: quiz.php');
    exit;
}

$results = $_SESSION['quiz_results'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Résultats du Quiz</title>
</head>
<body>
    <h1>Résultats du Quiz</h1>
    <p>Questions correctes : <?php echo $results['correct_answers']; ?> / <?php echo $results['total_questions']; ?></p>
    <a href="quiz.php">Recommencer le quiz</a>
</body>
</html>
