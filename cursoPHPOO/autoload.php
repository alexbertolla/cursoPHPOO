<?php

define('CLASS_DIR', 'src/');
spl_autoload_register(function($className) {
    $path = str_replace("\\", "/", $className . ".php");
    $file = CLASS_DIR . $path;
    if (is_file($file)) {
        require_once($file);
    } else {
        echo "Could not load class {$className}. File not found: {$file}";
        die();
    }
});
