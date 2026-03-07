<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-person-circle"></i> Admin Profile</h2>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Profile updated successfully!</div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] === 'password'): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Password changed successfully!</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body text-center py-4">
                <div class="profile-avatar" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h4 class="fw-bold"><?= htmlspecialchars($user->name) ?></h4>
                <span class="badge bg-danger mb-3">Admin</span>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <a href="/mini_OnShop/admin/editProfile" class="btn btn-gradient"><i class="bi bi-pencil"></i> Edit Profile</a>
                    <a href="/mini_OnShop/admin/changePassword" class="btn btn-outline-danger"><i class="bi bi-shield-lock"></i> Change Password</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header gradient-header">
                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Links</h5>
            </div>
            <div class="card-body">
                <a href="/mini_OnShop/admin/dashboard" class="quick-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="/mini_OnShop/admin/users" class="quick-link"><i class="bi bi-people"></i> Manage Users</a>
                <a href="/mini_OnShop/admin/products" class="quick-link"><i class="bi bi-box-seam"></i> Manage Products</a>
                <a href="/mini_OnShop/admin/orders" class="quick-link"><i class="bi bi-receipt"></i> All Orders</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
