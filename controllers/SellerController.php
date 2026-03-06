<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class SellerController {
    private Product $product;
    private Order $order;

    public function __construct() {
        $this->product = new Product();
        $this->order = new Order();
    }

    public function dashboard() {
        $products = $this->product->findBySeller($_SESSION['user_id']);
        $sales = $this->order->getBySeller($_SESSION['user_id']);
        require __DIR__ . '/../views/seller/dashboard.php';
    }

    public function products() {
        $products = $this->product->findBySeller($_SESSION['user_id']);
        require __DIR__ . '/../views/seller/products.php';
    }

    public function addProduct() {
        require __DIR__ . '/../views/seller/add-product.php';
    }

    public function handleAddProduct() {
        $name = $_POST['name'] ?? '';
        $price = (float)($_POST['price'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 0);
        $seller_id = $_SESSION['user_id'];

        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = time() . '_' . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                $image = 'uploads/' . $filename;
            }
        }

        $this->product->create($name, $price, $qty, $seller_id, $image);
        header("Location: /mini_OnShop/seller/products?success=1");
        exit;
    }

    public function updatePrice() {
        $id = (int)$_POST['id'];
        $price = (float)$_POST['price'];

        if ($this->isOwner($id)) {
            $this->product->updatePrice($id, $price);
        }
        header("Location: /mini_OnShop/seller/products");
        exit;
    }

    public function restock() {
        $id = (int)$_POST['id'];
        $qty = (int)$_POST['quantity'];

        if ($this->isOwner($id)) {
            $this->product->restock($id, $qty);
        }
        header("Location: /mini_OnShop/seller/products");
        exit;
    }

    public function deleteProduct() {
        $id = (int)$_POST['id'];

        if ($this->isOwner($id)) {
            $this->product->delete($id);
        }
        header("Location: /mini_OnShop/seller/products");
        exit;
    }

    public function sales() {
        $sales = $this->order->getBySeller($_SESSION['user_id']);
        require __DIR__ . '/../views/seller/sales.php';
    }

    private function isOwner(int $product_id): bool {
        $product = $this->product->findById($product_id);
        return $product && $product->seller_id === $_SESSION['user_id'];
    }
}
