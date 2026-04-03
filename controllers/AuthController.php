<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public static function login()
    {
        global $pdo;
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = (new User($pdo))->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: index.php?page=dashboard');
                exit;
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        include __DIR__ . '/../views/auth/login.php';
    }

    public static function register()
    {
        global $pdo;
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ;

            $userModel = new User($pdo);
            if ($userModel->findByEmail($email)) {
                $error = "Email déjà utilisé.";
            } else {
                $userModel->create($name, $email, $password, $role);
                header('Location: index.php?page=login');
                exit;
            }
        }

        include __DIR__ . '/../views/auth/register.php';
    }

    public static function logout()
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
?>