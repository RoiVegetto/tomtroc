<?php

use Core\Controller;
use App\Models\User;
use App\Models\Book;

class AccountController extends Controller
{
    public function profile()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        $user = User::findById($userId);
        $books = Book::getByUserId($userId);

        $this->render('account/profile', [
            'user' => $user,
            'books' => $books
        ]);
    }

    public function profilePost()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $userId   = (int) $_SESSION['user_id'];
        $email    = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user  = User::findById($userId);
        $books = \App\Models\Book::getByUserId($userId);

        // validations simples
        if ($email === '' || $username === '') {
            return $this->render('account/profile', [
                'user'  => $user,
                'books' => $books,
                'error' => 'Email et pseudo sont obligatoires.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('account/profile', [
                'user'  => $user,
                'books' => $books,
                'error' => 'Email invalide.'
            ]);
        }

        // Unicité email / username
        if (User::emailTakenByAnother($email, $userId)) {
            return $this->render('account/profile', [
                'user'  => $user,
                'books' => $books,
                'error' => 'Cet email est déjà utilisé.'
            ]);
        }

        if (User::usernameTakenByAnother($username, $userId)) {
            return $this->render('account/profile', [
                'user'  => $user,
                'books' => $books,
                'error' => 'Ce pseudo est déjà utilisé.'
            ]);
        }

        // update email + username
        User::updateProfile($userId, $username, $email);

        // update password seulement si rempli
        if ($password !== '') {
            User::updatePassword($userId, $password);
        }

        // Upload avatar (optionnel)
        if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $tmp  = $_FILES['avatar']['tmp_name'];
            $name = $_FILES['avatar']['name'];

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed, true)) {
                return $this->render('account/profile', [
                    'user'  => User::findById($userId),
                    'books' => $books,
                    'error' => "Format d'image non autorisé (jpg/jpeg/png/webp)."
                ]);
            }

            $dir = __DIR__ . '/../../public/uploads/avatars';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
            $destPath = $dir . '/' . $filename;

            if (!move_uploaded_file($tmp, $destPath)) {
                return $this->render('account/profile', [
                    'user'  => User::findById($userId),
                    'books' => $books,
                    'error' => "Impossible d'uploader l'image."
                ]);
            }

            // Chemin public stocké en BDD
            User::updateAvatar($userId, 'uploads/avatars/' . $filename);
        }

        // mettre à jour la session si pseudo changé
        $_SESSION['username'] = $username;

        header('Location: /tomtroc/public/account/profile');
        exit;
    }

    public function userProfile($userId)
    {
        $userId = (int) $userId;

        if ($userId <= 0) {
            die('ID utilisateur invalide');
        }

        $user = User::findById($userId);

        if (!$user) {
            die('Utilisateur introuvable');
        }

        $books = Book::getByUserId($userId);

        $this->render('users/profile', [
            'user' => $user,
            'books' => $books
        ]);
    }
}