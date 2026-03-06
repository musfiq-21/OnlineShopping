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
}
