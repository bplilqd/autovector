<?php

spl_autoload_register(function ($class_name) {
    // Convert the namespace to a file path
    $file_path = PATH . DS . 'app' . DS . str_replace('\\', DS, $class_name) . '.php';

    // Check if the file exists before connecting
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        echo "File $file_path not found";
    }
});
