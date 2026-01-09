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

        // mettre à jour la session si pseudo changé
        $_SESSION['username'] = $username;

        header('Location: /tomtroc/public/account/profile');
        exit;
    }
}