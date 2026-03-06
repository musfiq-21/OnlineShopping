<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mini_OnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/mini_OnShop/public/style.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        footer {
            margin-top: auto;
        }
    </style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a class="navbar-brand" href="/mini_OnShop/">mini_OnShop</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="navbar-nav me-auto">
                <?php if ($_SESSION['role'] === 'customer'): ?>
                    <a class="nav-link" href="/mini_OnShop/customer/home">Products</a>
                    <a class="nav-link" href="/mini_OnShop/customer/cart">Cart</a>
                    <a class="nav-link" href="/mini_OnShop/customer/orders">Orders</a>
                    <a class="nav-link" href="/mini_OnShop/customer/inbox">Chatbox</a>
                    <a class="nav-link" href="/mini_OnShop/customer/profile">Profile</a>
                <?php elseif ($_SESSION['role'] === 'seller'): ?>
                    <a class="nav-link" href="/mini_OnShop/seller/dashboard">Dashboard</a>
                    <a class="nav-link" href="/mini_OnShop/seller/products">Products</a>
                    <a class="nav-link" href="/mini_OnShop/seller/addProduct">Add Product</a>
                    <a class="nav-link" href="/mini_OnShop/seller/sales">Sales</a>
                    <a class="nav-link" href="/mini_OnShop/seller/reviews">Reviews</a>
                    <a class="nav-link" href="/mini_OnShop/seller/inbox">Chatbox</a>
                    <a class="nav-link" href="/mini_OnShop/seller/profile">Profile</a>
                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                    <a class="nav-link" href="/mini_OnShop/admin/dashboard">Dashboard</a>
                    <a class="nav-link" href="/mini_OnShop/admin/users">Users</a>
                    <a class="nav-link" href="/mini_OnShop/admin/products">Products</a>
                    <a class="nav-link" href="/mini_OnShop/admin/orders">Orders</a>
                    <a class="nav-link" href="/mini_OnShop/admin/inbox">Chatbox</a>
                    <a class="nav-link" href="/mini_OnShop/admin/profile">Profile</a>
                <?php endif; ?>
            </div>
            <span class="navbar-text text-white me-3">
                <?= htmlspecialchars($_SESSION['name']) ?>
                <span class="badge bg-<?= $_SESSION['role'] === 'admin' ? 'danger' : ($_SESSION['role'] === 'seller' ? 'primary' : 'secondary') ?>">
                    <?= $_SESSION['role'] ?>
                </span>
            </span>
            <a href="/mini_OnShop/auth/logout" class="btn btn-outline-light btn-sm">Logout</a>
        <?php else: ?>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/mini_OnShop/auth/login">Login</a>
                <a class="nav-link" href="/mini_OnShop/auth/signup">Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<main class="container py-4">
