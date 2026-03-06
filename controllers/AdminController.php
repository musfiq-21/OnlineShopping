<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class AdminController {
    private User $user;
    private Product $product;
    private Order $order;

    public function __construct() {
        $this->user = new User();
        $this->product = new Product();
        $this->order = new Order();
    }

    public function dashboard() {
        $totalUsers = count($this->user->getAll());
        $totalProducts = count($this->product->getAll());
        $recentOrders = $this->order->getAll();
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function users() {
        $users = $this->user->getAll();
        require __DIR__ . '/../views/admin/users.php';
    }

    public function createAdmin() {
        require __DIR__ . '/../views/admin/create-admin.php';
    }

    public function handleCreateAdmin() {
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->user->existsByName($name)) {
            header("Location: /mini_OnShop/admin/createAdmin?error=exists");
            exit;
        }

        $this->user->create($name, 'admin', $password);
        header("Location: /mini_OnShop/admin/users?success=1");
        exit;
    }

    public function deleteUser() {
        $id = (int)($_POST['id'] ?? 0);

        if ($id === $_SESSION['user_id']) {
            header("Location: /mini_OnShop/admin/users?error=self");
            exit;
        }

        $this->user->delete($id);
        header("Location: /mini_OnShop/admin/users?deleted=1");
        exit;
    }

    public function products() {
        $products = $this->product->getAll();
        require __DIR__ . '/../views/admin/products.php';
    }

    public function deleteProduct() {
        $id = (int)($_POST['id'] ?? 0);
        $this->product->delete($id);
        header("Location: /mini_OnShop/admin/products?deleted=1");
        exit;
    }

    public function orders() {
        $orders = $this->order->getAll();
        require __DIR__ . '/../views/admin/orders.php';
    }

    public function profile() {
        $user = $this->user->findById($_SESSION['user_id']);
        require __DIR__ . '/../views/admin/profile.php';
    }

    public function editProfile() {
        $user = $this->user->findById($_SESSION['user_id']);
        require __DIR__ . '/../views/admin/edit-profile.php';
    }

    public function handleEditProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/admin/profile");
            exit;
        }

        $new_name = $_POST['name'] ?? '';

        if (empty(trim($new_name))) {
            header("Location: /mini_OnShop/admin/editProfile?error=empty");
            exit;
        }

        if ($this->user->updateName($_SESSION['user_id'], $new_name)) {
            $_SESSION['name'] = $new_name;
            header("Location: /mini_OnShop/admin/profile?success=updated");
            exit;
        }

        header("Location: /mini_OnShop/admin/editProfile?error=exists");
        exit;
    }

    public function changePassword() {
        require __DIR__ . '/../views/admin/change-password.php';
    }

    public function handleChangePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/admin/profile");
            exit;
        }

        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            header("Location: /mini_OnShop/admin/changePassword?error=empty");
            exit;
        }

        if ($new_password !== $confirm_password) {
            header("Location: /mini_OnShop/admin/changePassword?error=mismatch");
            exit;
        }

        if (strlen($new_password) < 5) {
            header("Location: /mini_OnShop/admin/changePassword?error=weak");
            exit;
        }

        if (!$this->user->verifyPassword($_SESSION['user_id'], $current_password)) {
            header("Location: /mini_OnShop/admin/changePassword?error=incorrect");
            exit;
        }

        $this->user->updatePassword($_SESSION['user_id'], $new_password);
        header("Location: /mini_OnShop/admin/profile?success=password");
        exit;
    }
}
