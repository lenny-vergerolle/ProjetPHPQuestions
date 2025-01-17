<?php
try {
    // Connexion à la base SQLite
    $pdo = new PDO('sqlite:db.sqlite');
    
    // Gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion réussie à la base de données SQLite.";
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}
?>
