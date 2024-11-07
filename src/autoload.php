<?php
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/controller/'; // Caminho base das classes

    // Substitui os separadores de namespace por separadores de diretório => \ por /
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
