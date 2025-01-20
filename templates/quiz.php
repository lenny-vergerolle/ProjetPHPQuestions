<?php
    session_start(); // Start session

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Enregistrer les réponses de l'utilisateur dans la session
        // var_dump($_POST);
        if (!empty($_POST['quiz'])) {
            $_SESSION['quiz'] = $_POST['quiz']; // Sauvegarde toutes les réponses dans la session
            var_dump($_SESSION);
            echo "$_SESSION[quiz][name]";
        }
    }

    if (!empty($_SESSION['quiz'])) {
        echo "<h3>Réponses enregistrées :</h3>";
        foreach ($_SESSION['quiz']['name'] as $questionName => $answer) {
            echo "Question: " . $questionName . " - Réponse : $answer<br>";
        }
    }
?>