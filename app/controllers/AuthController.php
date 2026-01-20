<?php

use Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function register()
    {
        $this->render('auth/register', ['title' => 'Inscription - TomTroc']);
    }

    public function registerPost()
    {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            return $this->render('auth/register', ['error' => 'Tous les champs sont obligatoires.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('auth/register', ['error' => 'Email invalide.']);
        }

        if (User::findByEmail($email)) {
            return $this->render('auth/register', ['error' => 'Cet email est déjà utilisé.']);
        }

        User::create($username, $email, $password);

        // Option: auto-login après inscription
        $user = User::findByEmail($email);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: /tomtroc/public/');
        exit;
    }

    public function login()
    {
        $this->render('auth/login', ['title' => 'Connexion - TomTroc']);
    }

    public function loginPost()
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            return $this->render('auth/login', ['error' => 'Pseudo et mot de passe requis.']);
        }

        $user = User::findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return $this->render('auth/login', ['error' => 'Identifiants incorrects.']);
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: /tomtroc/public/');
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: /tomtroc/public/auth/login');
        exit;
    }
}
