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

        $title = $params['title'] ?? 'TomTroc - Échangez vos livres';
        unset($params['title']);

        extract($params);
        require __DIR__ . '/../views/layout/layout.php';
    }
}