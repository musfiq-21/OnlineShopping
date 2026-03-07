<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-person-circle"></i> Seller Profile</h2>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Profile updated successfully!</div>
<?php endif; ?>
<?php if (isset($_GET['success']) && $_GET['success'] === 'password'): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Password changed successfully!</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card mb-4">
            <div class="card-body text-center py-4">
                <div class="profile-avatar">
                    <i class="bi bi-shop"></i>
                </div>
                <h4 class="fw-bold"><?= htmlspecialchars($user->name) ?></h4>
                <span class="badge" style="background: var(--accent); color: #fff;">Seller</span>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <a href="/mini_OnShop/seller/editProfile" class="btn btn-gradient"><i class="bi bi-pencil"></i> Edit Profile</a>
                    <a href="/mini_OnShop/seller/changePassword" class="btn btn-outline-danger"><i class="bi bi-shield-lock"></i> Change Password</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header gradient-header">
                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Sales Overview</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="stat-value" style="color: #10b981;">BDT <?= number_format($totalSales, 2) ?></div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-value" style="color: var(--accent);"><?= $totalOrders ?></div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-value" style="color: #f59e0b;"><?= $totalProducts ?></div>
                        <div class="stat-label">Products</div>
                    </div>
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
                <a href="/mini_OnShop/seller/dashboard" class="quick-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="/mini_OnShop/seller/products" class="quick-link"><i class="bi bi-box-seam"></i> My Products</a>
                <a href="/mini_OnShop/seller/addProduct" class="quick-link"><i class="bi bi-plus-circle"></i> Add Product</a>
                <a href="/mini_OnShop/seller/sales" class="quick-link"><i class="bi bi-graph-up"></i> Sales</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
