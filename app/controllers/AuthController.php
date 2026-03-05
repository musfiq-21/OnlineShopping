<?php
require_once __DIR__ ."/../../core/Database.php";
require __DIR__ . "/../models/User.php";
require __DIR__ ."/../../core/utils.php";
class AuthController {
    private PDO $db;
    private User $userModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->userModel = new User();
    }

    public function showLogin() {
        
        require 'views/auth/login.php';
    }

    public function handleLogin() {
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByName($name);

        if ($user && password_verify($password, $user->hashed_password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['name']    = $user->name;
            $_SESSION['role']    = $user->role;

            header("Location: /" . $user->role . "/home");
            exit;
        }
        else {
            header("Location: /auth/login?error=1");
            exit;
        }
    }

    public function showSignup() {
        require 'views/auth/signup.php';
    }

    public function handleSignup() {
        $name     = $_POST['name'] ?? '';
        $role     = $_POST['role'] ?? 'customer';
        $password = $_POST['password'] ?? '';

        if ($this->userModel->existsByName($name)) {
            header("Location: /auth/signup?error=exists");
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        if ($this->userModel->create($name, $role, $hashed)) {
            header("Location: /auth/login?registered=1");
            exit;
        } else {
            die("Registration failed.");
        }
    }

    public function logout() {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: /auth/login");
        exit;
    }
}