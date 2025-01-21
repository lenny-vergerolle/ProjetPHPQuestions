<?php
session_start();
require_once '../autoload.php';
require_once '../BD/MajBD.php';

use BD\MajBD;

$majBD = new MajBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom_utilisateur'])) {
    $name = htmlspecialchars($_POST['nom_utilisateur']);
    
    // Enregistrez le nom dans la base de données et démarrez une session utilisateur
    $userId = $majBD->insertData($name);
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;
        
        // Redirection vers le quiz
        header('Location: ../templates/quiz.php');
        exit;
    } else {
        echo "Erreur : Impossible de se connecter.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
    <h1>Connexion</h1>
    <div class="connexion">
        <form action="" method="post">
            <label for="nom_utilisateur">Nom d'utilisateur:</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>