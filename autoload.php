<?php
declare(strict_types=1);

class Autoloader {
    public static function loadClass($className) {
        // Replace namespace separators with directory separators
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

        // Define the base directory (one level above the autoloader file)
        $baseDir = __DIR__ . '/';  // Adjust this path if needed

        // Build the full path to the class file
        $filePath = $baseDir . $className . '.php';

        // Check if the file exists, and if so, require it
        if (file_exists($filePath)) {
            require_once $filePath;
        } else {
            throw new Exception("Class file not found: $filePath");
        }
    }
}
