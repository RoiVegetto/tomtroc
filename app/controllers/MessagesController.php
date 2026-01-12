<?php

use Core\Controller;
use App\Models\Message;
use App\Models\User;

class MessagesController extends Controller
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];
        $messages = Message::inboxReceived($userId);

        $this->render('messages/index', [
            'messages' => $messages
        ]);
    }

    // /messages/thread/{id}
    public function thread($otherId = null)
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];
        $otherId = (int) $otherId;

        if ($otherId <= 0) {
            header('Location: /tomtroc/public/messages');
            exit;
        }

        // Marquer comme lus les messages venant de cet utilisateur
        Message::markThreadRead($userId, $otherId);

        $thread = Message::thread($userId, $otherId);
        $otherUser = User::findById($otherId);

        $this->render('messages/thread', [
            'thread' => $thread,
            'otherUser' => $otherUser
        ]);
    }

    public function sendPost()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $fromId = (int) $_SESSION['user_id'];
        $toId = (int) ($_POST['receiver_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if ($toId <= 0 || $content === '') {
            // Retour simple vers inbox si erreur
            header('Location: /tomtroc/public/messages');
            exit;
        }

        Message::send($fromId, $toId, $content);

        header('Location: /tomtroc/public/messages/thread/' . $toId);
        exit;
    }
}
