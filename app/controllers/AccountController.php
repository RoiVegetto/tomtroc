<?php

use Core\Controller;
use App\Models\User;

class AccountController extends Controller
{
    public function profile()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $user = User::findById((int)$_SESSION['user_id']);

        $this->render('account/profile', [
            'user' => $user
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

        // validations simples
        if ($email === '' || $username === '') {
            return $this->render('account/profile', [
                'user' => User::findById($userId),
                'error' => 'Email et pseudo sont obligatoires.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('account/profile', [
                'user' => User::findById($userId),
                'error' => 'Email invalide.'
            ]);
        }

        // Unicité email / username (si changé)
        if (User::emailTakenByAnother($email, $userId)) {
            return $this->render('account/profile', [
                'user' => User::findById($userId),
                'error' => 'Cet email est déjà utilisé.'
            ]);
        }

        if (User::usernameTakenByAnother($username, $userId)) {
            return $this->render('account/profile', [
                'user' => User::findById($userId),
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
