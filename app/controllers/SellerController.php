<?php
require __DIR__ ."/../../core/Database.php";
class SellerController {
    private PDO $db;
    private Product $productModel;
    private Sell $sellModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->productModel = new Product();
        $this->sellModel = new Sell();
    }

    public function home() {
        $seller_id = $_SESSION['user_id'];
        $myProducts = $this->productModel->findBySeller($seller_id);
        $recentSales = $this->sellModel->getBySeller($seller_id);
        
        require 'views/seller/home.php';
    }

    public function showAddProduct() {
        require 'views/seller/add_product.php';
    }

    public function handleAddProduct() {
        $name = $_POST['name'] ?? '';
        $price = (float)($_POST['price'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 0);
        $seller_id = $_SESSION['user_id'];

        $imagePath = null;
        if (isset($_FILES['stock_image']) && $_FILES['stock_image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "public/uploads/";
            $fileName = time() . "_" . basename($_FILES["stock_image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES["stock_image"]["tmp_name"], $targetFilePath)) {
                $imagePath = $targetFilePath;
            }
        }

        if ($this->productModel->create($name, $price, $qty, $seller_id, $imagePath)) {
            header("Location: /seller/products?success=added");
            exit;
        }
    }

    public function listProducts() {
        $products = $this->productModel->findBySeller($_SESSION['user_id']);
        require 'views/seller/product_list.php';
    }

    public function updatePrice() {
        $id = (int)$_POST['id'];
        $newPrice = (float)$_POST['price'];

        if ($this->isOwner($id)) {
            $this->productModel->updatePrice($id, $newPrice);
            header("Location: /seller/products?updated=1");
        } else {
            die("Unauthorized access to product.");
        }
    }

    public function restock() {
        $id = (int)$_POST['id'];
        $qty = (int)$_POST['quantity'];

        if ($this->isOwner($id)) {
            $this->productModel->restock($id, $qty);
            header("Location: /seller/products?restocked=1");
        }
    }

    public function deleteProduct() {
        $id = (int)$_POST['id'];

        if ($this->isOwner($id)) {
            $this->productModel->delete($id);
            header("Location: /seller/products?deleted=1");
        }
    }

    public function salesHistory() {
        $sales = $this->sellModel->getBySeller($_SESSION['user_id']);
        require 'views/seller/sales_history.php';
    }

    private function isOwner(int $product_id): bool {
        $product = $this->productModel->findById($product_id);
        return $product && $product->seller_id === $_SESSION['user_id'];
    }
}