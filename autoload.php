<?php
spl_autoload_register(function ($class) {
    // Convert the namespace to a file path
    $class = ltrim($class, '\\');
    $file = '';
    $namespace = '';

    if ($lastNsPos = strrpos($class, '\\')) {
        $namespace = substr($class, 0, $lastNsPos);
        $class = substr($class, $lastNsPos + 1);
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $file .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

    // Define the base directory for the namespace prefix
    $base_dir = __DIR__ . '/src/';

    // Construct the full path to the file
    $fullPath = $base_dir . $file;

    if (file_exists($fullPath)) {
        require $fullPath;
    }
});
