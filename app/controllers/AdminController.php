<?php
require __DIR__ ."/../../core/Database.php";
require __DIR__ . "/../models/User.php";
require __DIR__ . "/../models/Product.php";
require __DIR__ . "/../models/Sell.php";
class AdminController {
    private PDO $db;
    private User $userModel;
    private Product $productModel;
    private Sell $sellModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->userModel = new User();
        $this->productModel = new Product();
        $this->sellModel = new Sell();
    }

    public function dashboard() {

        $totalUsers = count($this->userModel->getAllUsers());
        $totalProducts = count($this->productModel->getAll());
        $recentSales = $this->sellModel->getAll();
        
        require 'views/admin/dashboard.php';
    }

    public function showRegisterAdmin() {
        require 'views/admin/register_admin.php';
    }

    public function handleRegisterAdmin() {
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->userModel->existsByName($name)) {
            header("Location: /admin/registerAdmin?error=exists");
            exit;
        }

        $hashed = password_hash(password: $password);
        
        if ($this->userModel->create($name, 'admin', $hashed)) {
            header("Location: /admin/users?success=admin_created");
            exit;
        }
    }

    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        require 'views/admin/user_list.php';
    }

    public function deleteUser() {
        $id = (int)($_POST['id'] ?? 0);
        
        if ($id === $_SESSION['user_id']) {
            header("Location: /admin/users?error=self_delete");
            exit;
        }

        if ($this->userModel->deleteById($id)) {
            header("Location: /admin/users?deleted=1");
            exit;
        }
    }

    public function listProducts() {
        $products = $this->productModel->getAll();
        require 'views/admin/product_list.php';
    }

    public function deleteProduct() {
        $id = (int)($_POST['id'] ?? 0);
        if ($this->productModel->delete($id)) {
            header("Location: /admin/products?deleted=1");
            exit;
        }
    }

    public function listTransactions() {
        $transactions = $this->sellModel->getAll();
        require 'views/admin/transaction_list.php';
    }
}