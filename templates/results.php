<?php
session_start();

// Vérification des résultats dans la session
if (!isset($_SESSION['quiz_results'])) {
    header('Location: quiz.php');
    exit;
}

$results = $_SESSION['quiz_results'];
$reponses = $_SESSION['reponses'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats du Quiz</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
    <div class="container">
        <h1>Résultats du Quiz</h1>
        <p><strong>Questions correctes :</strong> <?php echo htmlspecialchars($results['correct_answers']); ?> / <?php echo htmlspecialchars($results['total_questions']); ?></p>

        <h3>Vos réponses :</h3>
        <ul>
            <?php if (!empty($reponses)): ?>
                <?php foreach ($reponses as $reponse): ?>
                    <?php if (is_array($reponse)): ?>
                        <?php foreach ($reponse as $r): ?>
                            <li><?php echo htmlspecialchars($r); ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><?php echo htmlspecialchars($reponse); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune réponse donnée.</li>
            <?php endif; ?>
        </ul>

        <a href="quiz.php?reset=1" class="button">Recommencer le quiz</a>
    </div>
</body>
</html>
