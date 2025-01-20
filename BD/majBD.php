<?php

namespace BD;

use PDO;
use PDOException;

class MajBD
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('sqlite:' . __DIR__ . '/db.sqlite');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createTable();
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
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

    public function insertData(string $name): void
    {
        try {
            $insertData = "INSERT INTO JOUEUR (NOM, NB_QUESTIONS, SCORE_TOTAL, SCORE_CORRECT, NB_REPONSES_CORRECTES)VALUES (:name, 0, 0, 0, 0)";
            $stmt = $this->pdo->prepare($insertData);
            $stmt->execute(['name' => $name]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion des données : " . $e->getMessage();
        }
    }
    public function getLastId(): int{
        return $this->pdo->lastInsertId();

    }
        

    public function afficheJoueur(int $id): void
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

    public function incrementeQuestionsTotal(): void
    {
        $this->updateField(1,'NB_QUESTIONS', value: 1);
    }

    public function incrementeQuestionCorrect(int $id): void
    {
        $this->updateField($id, 'NB_REPONSES_CORRECTES', 1);
    }

    public function incrementeScoreCorrect(int $id, int $value): void
    {
        $this->updateField($id, 'SCORE_CORRECT', $value);
    }

    public function incrementeScoreTotal(int $id, int $value): void
    {
        $this->updateField($id, 'SCORE_TOTAL', $value);
    }

    private function updateField(int $id, string $field, int $value): void
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

