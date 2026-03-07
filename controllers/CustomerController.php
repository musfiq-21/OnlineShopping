<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Message.php';

class CustomerController {
    private Product $product;
    private Cart $cart;
    private Order $order;
    private Comment $comment;
    private User $user;

    public function __construct() {
        $this->product = new Product();
        $this->cart = new Cart();
        $this->order = new Order();
        $this->comment = new Comment();
        $this->user = new User();
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

    public function productDetail() {
        $product_id = (int)($_GET['id'] ?? 0);
        
        if ($product_id <= 0) {
            header("Location: /mini_OnShop/customer/home");
            exit;
        }

        $product = $this->product->findById($product_id);
        
        if (!$product) {
            header("Location: /mini_OnShop/customer/home?error=notfound");
            exit;
        }

        $seller = $this->user->findById($product->seller_id);
        $comments = $this->comment->getByProduct($product_id);
        
        require __DIR__ . '/../views/customer/product-detail.php';
    }

    public function addComment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/customer/home");
            exit;
        }

        $product_id = (int)($_POST['product_id'] ?? 0);
        $content = $_POST['content'] ?? '';

        if (!$product_id || empty(trim($content))) {
            header("Location: /mini_OnShop/customer/productDetail?id=$product_id&error=invalid");
            exit;
        }

        // Verify product exists
        if (!$this->product->findById($product_id)) {
            header("Location: /mini_OnShop/customer/home?error=notfound");
            exit;
        }

        $this->comment->create($_SESSION['user_id'], $product_id, $content);
        header("Location: /mini_OnShop/customer/productDetail?id=$product_id&success=1");
        exit;
    }

    public function profile() {
        $user = $this->user->findById($_SESSION['user_id']);
        require __DIR__ . '/../views/customer/profile.php';
    }

    public function editProfile() {
        $user = $this->user->findById($_SESSION['user_id']);
        require __DIR__ . '/../views/customer/edit-profile.php';
    }

    public function handleEditProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/customer/profile");
            exit;
        }

        $new_name = $_POST['name'] ?? '';

        if (empty(trim($new_name))) {
            header("Location: /mini_OnShop/customer/editProfile?error=empty");
            exit;
        }

        if ($this->user->updateName($_SESSION['user_id'], $new_name)) {
            $_SESSION['name'] = $new_name;
            header("Location: /mini_OnShop/customer/profile?success=updated");
            exit;
        }

        header("Location: /mini_OnShop/customer/editProfile?error=exists");
        exit;
    }

    public function changePassword() {
        require __DIR__ . '/../views/customer/change-password.php';
    }

    public function handleChangePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/customer/profile");
            exit;
        }

        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            header("Location: /mini_OnShop/customer/changePassword?error=empty");
            exit;
        }

        if ($new_password !== $confirm_password) {
            header("Location: /mini_OnShop/customer/changePassword?error=mismatch");
            exit;
        }

        if (strlen($new_password) < 5) {
            header("Location: /mini_OnShop/customer/changePassword?error=weak");
            exit;
        }

        if (!$this->user->verifyPassword($_SESSION['user_id'], $current_password)) {
            header("Location: /mini_OnShop/customer/changePassword?error=incorrect");
            exit;
        }

        $this->user->updatePassword($_SESSION['user_id'], $new_password);
        header("Location: /mini_OnShop/customer/profile?success=password");
        exit;
    }

    public function inbox() {
        $message = new Message();
        $conversations = $message->getConversations($_SESSION['user_id']);
        $unreadTotal = $message->getUnreadCount($_SESSION['user_id']);
        $role = 'customer';
        require __DIR__ . '/../views/shared/inbox.php';
    }

    public function conversation() {
        $other_id = (int)($_GET['with'] ?? 0);
        if ($other_id <= 0) {
            header("Location: /mini_OnShop/customer/inbox");
            exit;
        }

        $otherUser = $this->user->findById($other_id);
        if (!$otherUser || !in_array($otherUser->role, ['seller', 'admin'])) {
            header("Location: /mini_OnShop/customer/inbox");
            exit;
        }

        $message = new Message();
        $message->markAsRead($other_id, $_SESSION['user_id']);
        $messages = $message->getThread($_SESSION['user_id'], $other_id);
        $role = 'customer';
        require __DIR__ . '/../views/shared/conversation.php';
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/customer/inbox");
            exit;
        }

        $receiver_id = (int)($_POST['receiver_id'] ?? 0);
        $content = $_POST['content'] ?? '';

        if ($receiver_id <= 0 || empty(trim($content))) {
            header("Location: /mini_OnShop/customer/inbox");
            exit;
        }

        // Customers can only message sellers and admins
        $receiver = $this->user->findById($receiver_id);
        if (!$receiver || !in_array($receiver->role, ['seller', 'admin'])) {
            header("Location: /mini_OnShop/customer/inbox");
            exit;
        }

        $message = new Message();
        $message->send($_SESSION['user_id'], $receiver_id, $content);
        header("Location: /mini_OnShop/customer/conversation?with=$receiver_id");
        exit;
    }

    public function newMessage() {
        $users = $this->user->getAll();
        // Customers can only chat with sellers and admins
        $users = array_filter($users, fn($u) => $u->id !== $_SESSION['user_id'] && in_array($u->role, ['seller', 'admin']));
        $role = 'customer';
        require __DIR__ . '/../views/shared/new-message.php';
    }
}

