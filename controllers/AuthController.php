<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function login() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function handleLogin() {
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->user->findByName($name);

        if (!$user) {
            header("Location: /mini_OnShop/auth/login?error=1");
            exit;
        }

        // Check if password is valid (hashed or plain text migration)
        $isValid = false;
        $storedPassword = $user->hashed_password;

        if (str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$')) {
            // Password is hashed - use password_verify
            $isValid = password_verify($password, $storedPassword);
        } else {
            // Password is plain text - compare directly and upgrade
            $isValid = ($password === $storedPassword);
            if ($isValid) {
                // Upgrade to hashed password
                $this->user->updatePassword($user->id, $password);
            }
        }

        if ($isValid) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['name'] = $user->name;
            $_SESSION['role'] = $user->role;

            switch ($user->role) {
                case 'admin':
                    header("Location: /mini_OnShop/admin/dashboard");
                    break;
                case 'seller':
                    header("Location: /mini_OnShop/seller/dashboard");
                    break;
                default:
                    header("Location: /mini_OnShop/customer/home");
            }
            exit;
        }

        header("Location: /mini_OnShop/auth/login?error=1");
        exit;
    }

    public function signup() {
        require __DIR__ . '/../views/auth/signup.php';
    }

    public function handleSignup() {
        $name = $_POST['name'] ?? '';
        $role = $_POST['role'] ?? 'customer';
        $password = $_POST['password'] ?? '';

        if ($this->user->existsByName($name)) {
            header("Location: /mini_OnShop/auth/signup?error=exists");
            exit;
        }

        if ($this->user->create($name, $role, $password)) {
            header("Location: /mini_OnShop/auth/login?registered=1");
            exit;
        }

        header("Location: /mini_OnShop/auth/signup?error=failed");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: /mini_OnShop/auth/login");
        exit;
    }
}
