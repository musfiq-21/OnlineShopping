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

<div class="row justify-content-center">
    <div class="col-md-4">
        <h2 class="text-center mb-4">Sign Up</h2>
        
        <?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
            <div class="alert alert-danger">Username already exists</div>
        <?php endif; ?>
        
        <form method="POST" action="/mini_OnShop/auth/handleSignup">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="name" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="customer">Customer</option>
                    <option value="seller">Seller</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Create Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
        </form>
        
        <p class="text-center mt-3">
            Already have an account? <a href="/mini_OnShop/auth/login">Login</a>
        </p>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
