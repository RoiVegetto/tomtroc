<?php

namespace Core;

class Controller
{
    protected function render(string $view)
    {
        require_once "../app/views/layout/header.php";
        require_once "../app/views/$view.php";
        require_once "../app/views/layout/footer.php";
    }
}
