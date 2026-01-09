<?php
namespace Core;

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data); // transforme ['userCount' => 4] en $userCount = 4

        require __DIR__ . "/../views/layout/header.php";
        require __DIR__ . "/../views/$view.php";
        require __DIR__ . "/../views/layout/footer.php";
    }
}
