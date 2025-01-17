<?php
try {
    // Connexion à la base SQLite
    $pdo = new PDO('sqlite:db.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("DROP TABLE IF EXISTS JOUEUR");
    // Création de la table JOUEUR
    $createTable = "
        CREATE TABLE IF NOT EXISTS JOUEUR (
            ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            NOM TEXT NOT NULL,
            SCORE INT NOT NULL
        );
    ";
    $pdo->exec($createTable);

    // Insertion de données
    function insertData($pdo, $id, $name, $score) { 
        $insertData = "INSERT INTO JOUEUR (ID, NOM, SCORE) VALUES ($id, '$name', $score);";
        $pdo->exec($insertData);
    }
    function affichageJoueur($pdo,$id){
        try {
            $sql = "SELECT * FROM JOUEUR WHERE ID ='$id'"; 
            $stmt = $pdo->query($sql);    
        
            // affichage des résultats
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                echo "Nom: " . $row['NOM'] . PHP_EOL;
                echo PHP_EOL;
                echo "Score: " . $row['SCORE'] . PHP_EOL;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        }
        }   

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

try {
    $sql = "SELECT * FROM JOUEUR"; 
    $stmt = $pdo->query($sql);    

    // affichage des résultats
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        echo "ID: " . $row['ID'] . "\n";
        echo "Nom: " . $row['NOM'] . "\n";
        echo "Score: " . $row['SCORE'] . "\n\n";
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>


