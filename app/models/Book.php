<?php
namespace App\Models;

use Core\Database;

class Book
{
    public static function getByUserId(int $userId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT id, photo, title, author, description, is_available
            FROM books
            WHERE user_id = :user_id
            ORDER BY id DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getAvailable(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("
            SELECT id, photo, title, author, description, is_available
            FROM books
            WHERE is_available = 1
            ORDER BY id DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT
                b.*,
                u.username AS owner_username
            FROM books b
            JOIN users u ON u.id = b.user_id
            WHERE b.id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);
        $book = $stmt->fetch();

        return $book ?: null;
    }

}
