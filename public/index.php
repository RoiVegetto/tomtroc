<?php
session_start();

require_once __DIR__ . '/../app/core/Autoload.php';

use Core\Router;

$router = new Router();
$router->run();
