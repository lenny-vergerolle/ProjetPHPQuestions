<?php
declare(strict_types=1);

class Autoloader {
    public static function loadClass(string $fqcn): void {
        // Replace namespace backslashes with directory separators
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $fqcn) . '.php';

        if (!file_exists($path)) {
            throw new Exception("File not found: $path");
        }

        require_once $path;
    }
}
