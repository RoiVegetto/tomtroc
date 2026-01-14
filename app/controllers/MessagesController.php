<?php

use Core\Controller;
use App\Models\Message;
use App\Models\User;

class MessagesController extends Controller
{
    private function requireAuth()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }
    }

    // GET /messages
    public function index()
    {
        $this->requireAuth();

        $userId = (int)$_SESSION['user_id'];
        $threads = Message::inbox($userId);

        // On récupère le pseudo du "other user" pour affichage
        foreach ($threads as &$t) {
            $other = User::findById((int)$t['other_user_id']);
            $t['other_username'] = $other['username'] ?? 'Utilisateur';
        }

        $this->render('messages/index', [
            'threads' => $threads
        ]);
    }

    public function thread($conversationId)
    {
        $this->requireAuth();

        $conversationId = (int)$conversationId;
        $userId = (int)$_SESSION['user_id'];

        if (!Message::conversationBelongsTo($conversationId, $userId)) {
            http_response_code(403);
            die("Accès interdit");
        }

        $otherUserId = Message::getOtherUserId($conversationId, $userId);
        $otherUser = $otherUserId ? User::findById($otherUserId) : null;

        Message::markReadForUser($conversationId, $userId);
        $messages = Message::getConversationMessages($conversationId);

        $this->render('messages/thread', [
            'conversationId' => $conversationId,
            'messages'       => $messages,
            'otherUser'      => $otherUser, // ✅ pour afficher le pseudo en haut
        ]);
    }

    // GET /messages/new/{userId}
    public function new($receiverId)
    {
        $this->requireAuth();

        $receiverId = (int)$receiverId;
        $senderId = (int)$_SESSION['user_id'];

        if ($receiverId <= 0 || $receiverId === $senderId) {
            die("Destinataire invalide");
        }

        // ✅ Si la conversation existe déjà, on redirige directement vers le thread
        $existingConvId = Message::findConversationIdBetween($senderId, $receiverId);
        if ($existingConvId) {
            header("Location: /tomtroc/public/messages/thread/$existingConvId");
            exit;
        }

        $receiver = User::findById($receiverId);
        if (!$receiver) {
            die("Utilisateur introuvable");
        }

        $this->render('messages/new', [
            'receiver' => $receiver
        ]);
    }

    // POST /messages/new/{userId}
    public function newPost($receiverId)
    {
        $this->requireAuth();

        $receiverId = (int)$receiverId;
        $senderId = (int)$_SESSION['user_id'];
        $body = $_POST['body'] ?? '';

        if (!Message::send($senderId, $receiverId, $body)) {
            $receiver = User::findById($receiverId);
            return $this->render('messages/new', [
                'receiver' => $receiver,
                'error' => 'Message vide.'
            ]);
        }

        // ✅ Redirige vers la conversation (créée ou déjà existante)
        $convId = Message::getOrCreateConversation($senderId, $receiverId);
        header("Location: /tomtroc/public/messages/thread/$convId");
        exit;
    }

    // POST /messages/thread/{conversationId}
    public function threadPost($conversationId)
    {
        $this->requireAuth();

        $conversationId = (int)$conversationId;
        $userId = (int)$_SESSION['user_id'];
        $body = $_POST['body'] ?? '';

        if (!Message::conversationBelongsTo($conversationId, $userId)) {
            http_response_code(403);
            die("Accès interdit");
        }

        $receiverId = Message::getOtherUserId($conversationId, $userId);
        if (!$receiverId) {
            die("Conversation invalide");
        }

        if (!Message::send($userId, $receiverId, $body)) {
            $messages = Message::getConversationMessages($conversationId);
            $otherUser = User::findById($receiverId);

            return $this->render('messages/thread', [
                'conversationId' => $conversationId,
                'messages'       => $messages,
                'otherUser'      => $otherUser,
                'error'          => 'Message vide.'
            ]);
        }

        header("Location: /tomtroc/public/messages/thread/$conversationId");
        exit;
    }

}
