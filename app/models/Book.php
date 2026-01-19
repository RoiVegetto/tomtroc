<?php
namespace App\Models;

use Core\Database;
use PDO;

class Book
{
    public static function getByUserId(int $userId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT *
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
            SELECT b.id, b.photo, b.title, b.author, b.description, b.is_available, u.username AS owner_username
            FROM books b
            JOIN users u ON u.id = b.user_id
            WHERE b.is_available = 1
            ORDER BY b.id DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getLatest(int $limit = 4): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT b.id, b.photo, b.title, b.author, b.description, b.is_available, u.username AS owner_username
            FROM books b
            JOIN users u ON u.id = b.user_id
            WHERE b.is_available = 1
            ORDER BY b.id DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
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

    public static function update(int $id, array $data): bool
    {
        $pdo = Database::getConnection();
        $fields = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }

        $stmt = $pdo->prepare("UPDATE books SET " . implode(', ', $fields) . " WHERE id = :id");
        return $stmt->execute($params);
    }
}
