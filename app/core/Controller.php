<?php
namespace Core;

class Controller
{
    protected function render(string $view, array $params = [])
    {
        if (!empty($_SESSION['user_id'])) {
            $params['unreadCount'] = \App\Models\Message::countUnreadByUser(
                (int) $_SESSION['user_id']
            );
        }

        extract($params);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
}