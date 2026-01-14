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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action .= 'Post';
        }

        $controllerPath = __DIR__ . "/../controllers/$controllerName.php";

        if (!file_exists($controllerPath)) {
            die('Controller introuvable');
        }

        require_once $controllerPath;

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            die('Action introuvable');
        }

        // ✅ Passer un param si présent (3e segment)
        $param = $url[2] ?? null;

        if ($param !== null) {
            $controller->$action($param);
        } else {
            $params = array_slice($url, 2);
            call_user_func_array([$controller, $action], $params);
        }
    }
}