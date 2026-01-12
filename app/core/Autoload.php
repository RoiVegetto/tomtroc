<?php

spl_autoload_register(function ($class) {

    $class = str_replace('\\', '/', $class);
    $baseDir = __DIR__ . '/../'; // app/

    // Core\Xxx => app/core/Xxx.php
    if (str_starts_with($class, 'Core/')) {
        $relative = substr($class, 5); // enlève "Core/"
        $file = $baseDir . 'core/' . $relative . '.php';
        if (file_exists($file)) require_once $file;
        return;
    }

    // App\Models\Xxx => app/models/Xxx.php
    if (str_starts_with($class, 'App/Models/')) {
        $relative = substr($class, 11); // enlève "App/Models/"
        $file = $baseDir . 'models/' . $relative . '.php';
        if (file_exists($file)) require_once $file;
        return;
    }

    // Controllers sans namespace => app/controllers/Xxx.php
    $file = $baseDir . 'controllers/' . $class . '.php';
    if (file_exists($file)) require_once $file;
});