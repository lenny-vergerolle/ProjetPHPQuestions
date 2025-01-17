<?php
    session_start(); // Start session

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Enregistrer les réponses de l'utilisateur dans la session
        if (!empty($_POST['quiz'])) {
            $_SESSION['quiz'] = $_POST; // Sauvegarde toutes les réponses dans la session
        }
    }

    if (!empty($_SESSION['quiz'])) {
        echo "<h3>Réponses enregistrées :</h3>";
        foreach ($_SESSION['quiz'] as $questionName => $answer) {
            echo "Question: $questionName - Réponse: $answer<br>";
        }
    }
?>