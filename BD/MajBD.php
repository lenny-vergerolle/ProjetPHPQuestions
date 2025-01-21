<?php

namespace BD;

use PDO;
use PDOException;

class MajBD
//Permet de créer et de mettre à jour la base de données
{
    private PDO $pdo;

    public function __construct()
    //Permet de se connecter à la base de données
    {
        try {
            $this->pdo = new PDO('sqlite:' . __DIR__ . '/db.sqlite');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createTable();
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }
    private function deleteTable(): void
    //Permet de supprimer la table
    {
        try {
            $deleteTable = "DROP TABLE IF EXISTS JOUEUR";
            $this->pdo->exec($deleteTable);
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la table : " . $e->getMessage();
        }
    }

    private function createTable(): void
    {
        try {
            $createTable = "
                CREATE TABLE IF NOT EXISTS JOUEUR (
                    ID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    NOM TEXT NOT NULL,
                    NB_QUESTIONS INTEGER NOT NULL,
                    SCORE_TOTAL INTEGER NOT NULL,
                    SCORE_CORRECT INTEGER NOT NULL,
                    NB_REPONSES_CORRECTES INTEGER NOT NULL
                );
            ";
            $this->pdo->exec($createTable);
        } catch (PDOException $e) {
            echo "Erreur lors de la création de la table : " . $e->getMessage();
        }
    }
    

    public function insertData(string $name): int
    //Permet d'insérer les données du joueur dans la base de données
{
    try {
        $insertData = "INSERT INTO JOUEUR (NOM, NB_QUESTIONS, SCORE_TOTAL, SCORE_CORRECT, NB_REPONSES_CORRECTES) VALUES (:name, 0, 0, 0, 0)";
        $stmt = $this->pdo->prepare($insertData);
        $stmt->execute(['name' => $name]);
        return (int)$this->pdo->lastInsertId();
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion des données : " . $e->getMessage();
        return 0;
    }
}
    public function afficheJoueur(int $id): void
    //Permet d'afficher les données d'un joueur
    {
        try {
            $sql = "SELECT * FROM JOUEUR WHERE ID = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                echo "Nom: " . $row['NOM'] . PHP_EOL;
                echo "Score Total: " . $row['SCORE_TOTAL'] . PHP_EOL;
                echo "Score Correct: " . $row['SCORE_CORRECT'] . PHP_EOL;
                echo "Nombre de réponses correctes: " . $row['NB_REPONSES_CORRECTES'] . PHP_EOL;
                echo "Nombre de questions: " . $row['NB_QUESTIONS'] . PHP_EOL;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'affichage des données : " . $e->getMessage();
        }
    }

    public function incrementeQuestionsTotal($id): void
    //Permet d'incrémenter le nombre de questions posées
    {
        $this->updateField($id, 'NB_QUESTIONS', 1);
    }
    public function incrementeQuestionCorrect(int $id): void
    //Permet d'incrémenter le nombre de réponses correctes
    {
        $this->updateField($id, 'NB_REPONSES_CORRECTES', 1);
    }

    public function incrementeScoreCorrect(int $id, int $value): void
    //  Permet d'incrémenter le score correct
    {
        $this->updateField($id, 'SCORE_CORRECT', $value);
    }

    public function incrementeScoreTotal(int $id, int $value): void
    //Permet d'incrémenter le score total
    {
        $this->updateField($id, 'SCORE_TOTAL', $value);
    }

    private function updateField(int $id, string $field, int $value): void
    //Permet de mettre à jour un champ de la base de données
{
    try {
        
        $sql = "UPDATE JOUEUR SET $field = $field + :value WHERE ID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['value' => $value, 'id' => $id]);
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de $field : " . $e->getMessage();
    }
}
    public function afficheTousLesJoueurs(): void
    //Permet d'afficher tous les joueurs
    {
        try {
            $sql = "SELECT * FROM JOUEUR";
            $stmt = $this->pdo->query($sql);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                echo "ID: " . $row['ID'] . PHP_EOL;
                echo "Nom: " . $row['NOM'] . PHP_EOL;
                echo "Score Total: " . $row['SCORE_TOTAL'] . PHP_EOL;
                echo "Score Correct: " . $row['SCORE_CORRECT'] . PHP_EOL;
                echo "Nombre de réponses correctes: " . $row['NB_REPONSES_CORRECTES'] . PHP_EOL;
                echo "Nombre de questions: " . $row['NB_QUESTIONS'] . PHP_EOL;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'affichage des joueurs : " . $e->getMessage();
        }
    }
}

?>

