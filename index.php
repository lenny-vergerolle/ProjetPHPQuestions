<?php
session_start(); // Démarrer la session

require_once 'autoload.php';
spl_autoload_register(callback: ['Autoloader', 'loadClass']);

// Activation des erreurs pour le débogage
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Vérification de l'état de la connexion
if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est connecté, rediriger vers la page du quiz
    header('Location: templates/quiz.php');
    exit;
} else {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: templates/login.php');
    exit;
}
