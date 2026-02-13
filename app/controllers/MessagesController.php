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

        // On récupère le pseudo et avatar du "other user" pour affichage
        foreach ($threads as &$t) {
            $other = User::findById((int)$t['other_user_id']);
            $t['other_username'] = $other['username'] ?? 'Utilisateur';
            $t['other_user_avatar'] = $other['avatar'] ?? '';
        }

        // Si un paramètre ?conv=X est présent, on charge cette conversation
        $selectedConversation = null;
        $messages = [];
        
        if (!empty($_GET['conv'])) {
            $conversationId = (int)$_GET['conv'];
            
            // Vérifier que l'utilisateur a accès à cette conversation
            if (Message::conversationBelongsTo($conversationId, $userId)) {
                Message::markReadForUser($conversationId, $userId);
                $messages = Message::getConversationMessages($conversationId);
                
                $otherUserId = Message::getOtherUserId($conversationId, $userId);
                $otherUser = $otherUserId ? User::findById($otherUserId) : null;
                
                $selectedConversation = [
                    'conversation_id' => $conversationId,
                    'other_username' => $otherUser['username'] ?? 'Utilisateur',
                    'other_user_avatar' => $otherUser['avatar'] ?? ''
                ];
            }
        }

        $this->render('messages/index', [
            'title' => 'Messagerie - TomTroc',
            'threads' => $threads,
            'selectedConversation' => $selectedConversation,
            'messages' => $messages
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

        header("Location: /tomtroc/public/messages?conv=$conversationId");
        exit;
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

        // ✅ Si la conversation existe déjà, on redirige directement vers la messagerie
        $existingConvId = Message::findConversationIdBetween($senderId, $receiverId);
        if ($existingConvId) {
            header("Location: /tomtroc/public/messages?conv=$existingConvId");
            exit;
        }

        $receiver = User::findById($receiverId);
        if (!$receiver) {
            die("Utilisateur introuvable");
        }

        // ✅ Sinon on crée la conversation puis on ouvre la messagerie directement
        $convId = Message::getOrCreateConversation($senderId, $receiverId);
        header("Location: /tomtroc/public/messages?conv=$convId");
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
            header("Location: /tomtroc/public/messages?conv=$conversationId");
            exit;
        }

        header("Location: /tomtroc/public/messages?conv=$conversationId");
        exit;
    }

    // API pour récupérer les messages d'une conversation en JSON
    public function getMessages($conversationId)
    {
        $this->requireAuth();

        $conversationId = (int)$conversationId;
        $userId = (int)$_SESSION['user_id'];

        if (!Message::conversationBelongsTo($conversationId, $userId)) {
            http_response_code(403);
            echo json_encode(['error' => 'Accès interdit']);
            exit;
        }

        Message::markReadForUser($conversationId, $userId);
        $messages = Message::getConversationMessages($conversationId);
        $otherUserId = Message::getOtherUserId($conversationId, $userId);
        $otherUser = $otherUserId ? User::findById($otherUserId) : null;

        header('Content-Type: application/json');
        echo json_encode([
            'conversationId' => $conversationId,
            'messages' => $messages,
            'otherUser' => $otherUser
        ]);
        exit;
    }
}
