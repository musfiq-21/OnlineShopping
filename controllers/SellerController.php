<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Message.php';

class SellerController {
    private Product $product;
    private Order $order;
    private User $user;
    private Comment $comment;

    public function __construct() {
        $this->product = new Product();
        $this->order = new Order();
        $this->user = new User();
        $this->comment = new Comment();
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

    public function reviews() {
        $comments = $this->comment->getBySeller($_SESSION['user_id']);
        require __DIR__ . '/../views/seller/reviews.php';
    }

    private function isOwner(int $product_id): bool {
        $product = $this->product->findById($product_id);
        return $product && $product->seller_id === $_SESSION['user_id'];
    }

    public function profile() {
        $user = $this->user->findById($_SESSION['user_id']);
        $products = $this->product->findBySeller($_SESSION['user_id']);
        $sales = $this->order->getBySeller($_SESSION['user_id']);
        $totalSales = array_sum(array_column($sales, 'Total_price'));
        $totalOrders = count($sales);
        $totalProducts = count($products);
        require __DIR__ . '/../views/seller/profile.php';
    }

    public function editProfile() {
        $user = $this->user->findById($_SESSION['user_id']);
        require __DIR__ . '/../views/seller/edit-profile.php';
    }

    public function handleEditProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/seller/profile");
            exit;
        }

        $new_name = $_POST['name'] ?? '';

        if (empty(trim($new_name))) {
            header("Location: /mini_OnShop/seller/editProfile?error=empty");
            exit;
        }

        if ($this->user->updateName($_SESSION['user_id'], $new_name)) {
            $_SESSION['name'] = $new_name;
            header("Location: /mini_OnShop/seller/profile?success=updated");
            exit;
        }

        header("Location: /mini_OnShop/seller/editProfile?error=exists");
        exit;
    }

    public function changePassword() {
        require __DIR__ . '/../views/seller/change-password.php';
    }

    public function handleChangePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/seller/profile");
            exit;
        }

        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            header("Location: /mini_OnShop/seller/changePassword?error=empty");
            exit;
        }

        if ($new_password !== $confirm_password) {
            header("Location: /mini_OnShop/seller/changePassword?error=mismatch");
            exit;
        }

        if (strlen($new_password) < 5) {
            header("Location: /mini_OnShop/seller/changePassword?error=weak");
            exit;
        }

        if (!$this->user->verifyPassword($_SESSION['user_id'], $current_password)) {
            header("Location: /mini_OnShop/seller/changePassword?error=incorrect");
            exit;
        }

        $this->user->updatePassword($_SESSION['user_id'], $new_password);
        header("Location: /mini_OnShop/seller/profile?success=password");
        exit;
    }

    public function editProduct() {
        $product_id = (int)($_GET['id'] ?? 0);

        if (!$this->isOwner($product_id)) {
            header("Location: /mini_OnShop/seller/products");
            exit;
        }

        $product = $this->product->findById($product_id);
        require __DIR__ . '/../views/seller/edit-product.php';
    }

    public function handleEditProduct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/seller/products");
            exit;
        }

        $product_id = (int)($_POST['product_id'] ?? 0);

        if (!$this->isOwner($product_id)) {
            header("Location: /mini_OnShop/seller/products");
            exit;
        }

        $name = $_POST['name'] ?? '';
        $price = (float)($_POST['price'] ?? 0);
        $product = $this->product->findById($product_id);

        if (empty(trim($name)) || $price <= 0) {
            header("Location: /mini_OnShop/seller/editProduct?id=$product_id&error=invalid");
            exit;
        }

        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = __DIR__ . '/../public/' . $product->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $filename = time() . '_' . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                $image = 'uploads/' . $filename;
            }
        }

        $this->product->updateDetails($product_id, $name, $price, $image);
        header("Location: /mini_OnShop/seller/products?success=updated");
        exit;
    }

    public function inbox() {
        $message = new Message();
        $conversations = $message->getConversations($_SESSION['user_id']);
        $unreadTotal = $message->getUnreadCount($_SESSION['user_id']);
        $role = 'seller';
        require __DIR__ . '/../views/shared/inbox.php';
    }

    public function conversation() {
        $other_id = (int)($_GET['with'] ?? 0);
        if ($other_id <= 0) {
            header("Location: /mini_OnShop/seller/inbox");
            exit;
        }

        $otherUser = $this->user->findById($other_id);
        if (!$otherUser || !in_array($otherUser->role, ['customer', 'admin'])) {
            header("Location: /mini_OnShop/seller/inbox");
            exit;
        }

        $message = new Message();
        $message->markAsRead($other_id, $_SESSION['user_id']);
        $messages = $message->getThread($_SESSION['user_id'], $other_id);
        $role = 'seller';
        require __DIR__ . '/../views/shared/conversation.php';
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /mini_OnShop/seller/inbox");
            exit;
        }

        $receiver_id = (int)($_POST['receiver_id'] ?? 0);
        $content = $_POST['content'] ?? '';

        if ($receiver_id <= 0 || empty(trim($content))) {
            header("Location: /mini_OnShop/seller/inbox");
            exit;
        }

        // Sellers can only message customers and admins
        $receiver = $this->user->findById($receiver_id);
        if (!$receiver || !in_array($receiver->role, ['customer', 'admin'])) {
            header("Location: /mini_OnShop/seller/inbox");
            exit;
        }

        $message = new Message();
        $message->send($_SESSION['user_id'], $receiver_id, $content);
        header("Location: /mini_OnShop/seller/conversation?with=$receiver_id");
        exit;
    }

    public function newMessage() {
        $users = $this->user->getAll();
        // Sellers can only chat with customers and admins
        $users = array_filter($users, fn($u) => $u->id !== $_SESSION['user_id'] && in_array($u->role, ['customer', 'admin']));
        $role = 'seller';
        require __DIR__ . '/../views/shared/new-message.php';
    }
}
