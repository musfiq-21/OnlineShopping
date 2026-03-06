<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php
// Redirect logged-in users to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: /mini_OnShop/admin/dashboard');
    } elseif ($_SESSION['role'] === 'seller') {
        header('Location: /mini_OnShop/seller/dashboard');
    } else {
        header('Location: /mini_OnShop/customer/home');
    }
    exit();
}
?>

<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
    }
</style>

<div class="login-container">
    <div class="col-md-4">
        <h2 class="text-center mb-4">Login</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Invalid username or password</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Registration successful! Please login.</div>
        <?php endif; ?>
        
        <form method="POST" action="/mini_OnShop/auth/handleLogin">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="name" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        
        <p class="text-center mt-3">
            Don't have an account? <a href="/mini_OnShop/auth/signup">Sign up</a>
        </p>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
