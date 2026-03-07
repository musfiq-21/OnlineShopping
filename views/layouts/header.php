<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mini_OnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/mini_OnShop/public/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/mini_OnShop/">
            <span class="brand-icon"><i class="bi bi-shop"></i></span>
            mini_OnShop
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="navbar-nav me-auto">
                <?php if ($_SESSION['role'] === 'customer'): ?>
                    <a class="nav-link" href="/mini_OnShop/customer/home"><i class="bi bi-grid"></i> Products</a>
                    <a class="nav-link" href="/mini_OnShop/customer/cart"><i class="bi bi-cart3"></i> Cart</a>
                    <a class="nav-link" href="/mini_OnShop/customer/orders"><i class="bi bi-receipt"></i> Orders</a>
                    <a class="nav-link" href="/mini_OnShop/customer/inbox"><i class="bi bi-chat-dots"></i> Chatbox</a>
                    <a class="nav-link" href="/mini_OnShop/customer/profile"><i class="bi bi-person-circle"></i> Profile</a>
                <?php elseif ($_SESSION['role'] === 'seller'): ?>
                    <a class="nav-link" href="/mini_OnShop/seller/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a class="nav-link" href="/mini_OnShop/seller/products"><i class="bi bi-box-seam"></i> Products</a>
                    <a class="nav-link" href="/mini_OnShop/seller/addProduct"><i class="bi bi-plus-circle"></i> Add</a>
                    <a class="nav-link" href="/mini_OnShop/seller/sales"><i class="bi bi-graph-up"></i> Sales</a>
                    <a class="nav-link" href="/mini_OnShop/seller/reviews"><i class="bi bi-star"></i> Reviews</a>
                    <a class="nav-link" href="/mini_OnShop/seller/inbox"><i class="bi bi-chat-dots"></i> Chatbox</a>
                    <a class="nav-link" href="/mini_OnShop/seller/profile"><i class="bi bi-person-circle"></i> Profile</a>
                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                    <a class="nav-link" href="/mini_OnShop/admin/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a class="nav-link" href="/mini_OnShop/admin/users"><i class="bi bi-people"></i> Users</a>
                    <a class="nav-link" href="/mini_OnShop/admin/products"><i class="bi bi-box-seam"></i> Products</a>
                    <a class="nav-link" href="/mini_OnShop/admin/orders"><i class="bi bi-receipt"></i> Orders</a>
                    <a class="nav-link" href="/mini_OnShop/admin/inbox"><i class="bi bi-chat-dots"></i> Chatbox</a>
                    <a class="nav-link" href="/mini_OnShop/admin/profile"><i class="bi bi-person-circle"></i> Profile</a>
                <?php endif; ?>
            </div>
            <div class="nav-user">
                <span class="user-name"><?= htmlspecialchars($_SESSION['name']) ?></span>
                <span class="user-badge badge-<?= $_SESSION['role'] ?>"><?= ucfirst($_SESSION['role']) ?></span>
                <a href="/mini_OnShop/auth/logout" class="btn-logout"><i class="bi bi-box-arrow-right"></i></a>
            </div>
        <?php else: ?>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/mini_OnShop/auth/login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                <a class="nav-link" href="/mini_OnShop/auth/signup"><i class="bi bi-person-plus"></i> Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<main class="container py-4">
