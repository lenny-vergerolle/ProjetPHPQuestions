<?php
declare(strict_types=1);

// Déclaration de la classe Autoloader
class Autoloader {
    // Méthode statique pour charger une classe
    public static function loadClass($className) {
        // Remplacer les backslashes par des séparateurs de répertoires
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

        // Définir le répertoire de base
        $baseDir = __DIR__ . '/'; 

        // Construire le chemin complet du fichier de la classe
        $filePath = $baseDir . $className . '.php';

        // Vérifier si le fichier existe
        if (file_exists($filePath)) {
            // Inclure le fichier de la classe
            require_once $filePath;
        } else {
            // Lancer une exception si le fichier de la classe n'est pas trouvé
            throw new Exception("Class file not found: $filePath");
        }
    }
}
