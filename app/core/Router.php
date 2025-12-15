<?php

namespace Core;

class Router
{
    public function run()
    {
        $url = $_GET['url'] ?? 'home/index';
        $url = explode('/', $url);

        $controllerName = ucfirst($url[0]) . 'Controller';
        $action = $url[1] ?? 'index';

        $controllerPath = "../app/controllers/$controllerName.php";

        if (!file_exists($controllerPath)) {
            die('Controller introuvable');
        }

        require_once $controllerPath;

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            die('Action introuvable');
        }

        $controller->$action();
    }
}
