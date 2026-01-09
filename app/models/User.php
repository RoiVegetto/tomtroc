<?php
namespace App\Models;

use Core\Database;

class User
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findByUsername(string $username): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(string $username, string $email, string $password): bool
    {
        $pdo = Database::getConnection();
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password_hash)
            VALUES (:username, :email, :password_hash)
        ");

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $hash,
        ]);
    }

    public static function countUsers(): int
    {
        $pdo = Database::getConnection();
        return (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, username, email, password_hash FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function emailTakenByAnother(string $email, int $userId): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id <> :id LIMIT 1");
        $stmt->execute(['email' => $email, 'id' => $userId]);
        return (bool) $stmt->fetch();
    }

    public static function usernameTakenByAnother(string $username, int $userId): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username AND id <> :id LIMIT 1");
        $stmt->execute(['username' => $username, 'id' => $userId]);
        return (bool) $stmt->fetch();
    }

    public static function updateProfile(int $userId, string $username, string $email): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'id' => $userId
        ]);
    }

    public static function updatePassword(int $userId, string $password): bool
    {
        $pdo = Database::getConnection();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id");
        return $stmt->execute([
            'hash' => $hash,
            'id' => $userId
        ]);
    }

}
