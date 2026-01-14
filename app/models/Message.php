<?php
namespace App\Models;

use Core\Database;

class Message
{
    // Normalise une paire (user1 < user2) pour garantir l'unicité
    private static function normalizePair(int $a, int $b): array
    {
        return ($a < $b) ? [$a, $b] : [$b, $a];
    }

    /**
     * Retourne l'id de conversation si elle existe déjà entre 2 users, sinon null
     */
    public static function findConversationIdBetween(int $userA, int $userB): ?int
    {
        [$user1, $user2] = self::normalizePair($userA, $userB);

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id
            FROM conversations
            WHERE user1_id = :u1 AND user2_id = :u2
            LIMIT 1
        ");
        $stmt->execute(['u1' => $user1, 'u2' => $user2]);

        $id = $stmt->fetchColumn();
        return $id ? (int)$id : null;
    }

    public static function getOrCreateConversation(int $userA, int $userB): int
    {
        [$user1, $user2] = self::normalizePair($userA, $userB);

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT id FROM conversations WHERE user1_id = :u1 AND user2_id = :u2 LIMIT 1");
        $stmt->execute(['u1' => $user1, 'u2' => $user2]);
        $convId = $stmt->fetchColumn();

        if ($convId) return (int)$convId;

        $stmt = $pdo->prepare("INSERT INTO conversations (user1_id, user2_id) VALUES (:u1, :u2)");
        $stmt->execute(['u1' => $user1, 'u2' => $user2]);

        return (int)$pdo->lastInsertId();
    }

    public static function send(int $senderId, int $receiverId, string $body): bool
    {
        $body = trim($body);
        if ($body === '') return false;

        $pdo = Database::getConnection();
        $convId = self::getOrCreateConversation($senderId, $receiverId);

        $stmt = $pdo->prepare("
            INSERT INTO messages (conversation_id, sender_id, receiver_id, body)
            VALUES (:cid, :sid, :rid, :body)
        ");

        return $stmt->execute([
            'cid'  => $convId,
            'sid'  => $senderId,
            'rid'  => $receiverId,
            'body' => $body,
        ]);
    }

    // Inbox : liste des conversations + dernier message + nb non lus
    public static function inbox(int $userId): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT
              c.id AS conversation_id,
              CASE
                WHEN c.user1_id = :uid THEN c.user2_id
                ELSE c.user1_id
              END AS other_user_id,

              (SELECT body
               FROM messages m
               WHERE m.conversation_id = c.id
               ORDER BY m.created_at DESC, m.id DESC
               LIMIT 1) AS last_body,

              (SELECT created_at
               FROM messages m
               WHERE m.conversation_id = c.id
               ORDER BY m.created_at DESC, m.id DESC
               LIMIT 1) AS last_at,

              (SELECT COUNT(*)
               FROM messages m
               WHERE m.conversation_id = c.id
                 AND m.receiver_id = :uid
                 AND m.is_read = 0) AS unread_count
            FROM conversations c
            WHERE c.user1_id = :uid OR c.user2_id = :uid
            ORDER BY last_at DESC
        ");

        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getConversationMessages(int $conversationId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id, sender_id, receiver_id, body, is_read, created_at
            FROM messages
            WHERE conversation_id = :cid
            ORDER BY created_at ASC, id ASC
        ");
        $stmt->execute(['cid' => $conversationId]);
        return $stmt->fetchAll();
    }

    public static function conversationBelongsTo(int $conversationId, int $userId): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM conversations
            WHERE id = :cid AND (user1_id = :uid OR user2_id = :uid)
        ");
        $stmt->execute(['cid' => $conversationId, 'uid' => $userId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public static function markReadForUser(int $conversationId, int $userId): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE messages
            SET is_read = 1
            WHERE conversation_id = :cid AND receiver_id = :uid AND is_read = 0
        ");
        $stmt->execute(['cid' => $conversationId, 'uid' => $userId]);
    }

    public static function countUnread(int $userId): int
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = :uid AND is_read = 0");
        $stmt->execute(['uid' => $userId]);
        return (int)$stmt->fetchColumn();
    }

    public static function countUnreadByUser(int $userId): int
    {
        return self::countUnread($userId);
    }

    public static function getOtherUserId(int $conversationId, int $userId): ?int
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT user1_id, user2_id FROM conversations WHERE id = :cid LIMIT 1");
        $stmt->execute(['cid' => $conversationId]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $u1 = (int)$row['user1_id'];
        $u2 = (int)$row['user2_id'];

        if ($userId === $u1) return $u2;
        if ($userId === $u2) return $u1;

        return null;
    }

}
