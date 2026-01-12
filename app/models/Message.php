<?php
namespace App\Models;

use Core\Database;

class Message
{
    public static function inboxReceived(int $userId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT m.*, u.username AS sender_username
            FROM messages m
            JOIN users u ON u.id = m.sender_id
            WHERE m.receiver_id = :uid
            ORDER BY m.created_at DESC
        ");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public static function thread(int $userId, int $otherId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT m.*,
                   us.username AS sender_username,
                   ur.username AS receiver_username
            FROM messages m
            JOIN users us ON us.id = m.sender_id
            JOIN users ur ON ur.id = m.receiver_id
            WHERE (m.sender_id = :me AND m.receiver_id = :other)
               OR (m.sender_id = :other AND m.receiver_id = :me)
            ORDER BY m.created_at ASC
        ");
        $stmt->execute(['me' => $userId, 'other' => $otherId]);
        return $stmt->fetchAll();
    }

    public static function send(int $fromId, int $toId, string $content): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO messages (sender_id, receiver_id, content)
            VALUES (:from_id, :to_id, :content)
        ");
        return $stmt->execute([
            'from_id' => $fromId,
            'to_id' => $toId,
            'content' => $content
        ]);
    }

    public static function markThreadRead(int $userId, int $otherId): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE messages
            SET is_read = 1
            WHERE receiver_id = :me
              AND sender_id = :other
              AND is_read = 0
        ");
        $stmt->execute(['me' => $userId, 'other' => $otherId]);
    }

    public static function countUnread(int $userId): int
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM messages
            WHERE receiver_id = :me AND is_read = 0
        ");
        $stmt->execute(['me' => $userId]);
        return (int) $stmt->fetchColumn();
    }

        public static function countUnreadByUser(int $userId): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM messages 
            WHERE receiver_id = :user_id 
            AND is_read = 0
        ");

        $stmt->execute(['user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }
}
