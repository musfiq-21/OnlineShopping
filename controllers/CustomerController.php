<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';

class CustomerController {
    private Product $product;
    private Cart $cart;
    private Order $order;

    public function __construct() {
        $this->product = new Product();
        $this->cart = new Cart();
        $this->order = new Order();
    }

    public function home() {
        $products = $this->product->getAll();
        require __DIR__ . '/../views/customer/home.php';
    }

    public function search() {
        $keyword = $_GET['q'] ?? '';
        $products = $this->product->search($keyword);
        require __DIR__ . '/../views/customer/search.php';
    }

    public function cart() {
        $items = $this->cart->getByUser($_SESSION['user_id']);
        $total = array_reduce($items, fn($sum, $item) => $sum + ($item['unit_price'] * $item['Quantity']), 0);
        require __DIR__ . '/../views/customer/cart.php';
    }

    public function addToCart() {
        $product_id = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        $this->cart->add($_SESSION['user_id'], $product_id, $quantity);
        header("Location: /mini_OnShop/customer/cart");
        exit;
    }

    public function removeFromCart() {
        $product_id = (int)($_POST['product_id'] ?? 0);
        $this->cart->remove($_SESSION['user_id'], $product_id);
        header("Location: /mini_OnShop/customer/cart");
        exit;
    }

    public function checkout() {
        $user_id = $_SESSION['user_id'];
        $items = $this->cart->getByUser($user_id);

        if (empty($items)) {
            header("Location: /mini_OnShop/customer/cart?error=empty");
            exit;
        }

        foreach ($items as $item) {
            $product = $this->product->findById($item['Product']);
            if ($product && $product->quantity >= $item['Quantity']) {
                $total = $item['unit_price'] * $item['Quantity'];
                $this->order->create($item['Product'], $user_id, $item['Quantity'], $total);
                $this->product->decrementStock($item['Product'], $item['Quantity']);
            }
        }

        $this->cart->clear($user_id);
        header("Location: /mini_OnShop/customer/orders?success=1");
        exit;
    }

    public function orders() {
        $orders = $this->order->getByBuyer($_SESSION['user_id']);
        require __DIR__ . '/../views/customer/orders.php';
    }
}
