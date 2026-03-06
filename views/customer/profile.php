<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Profile updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'password'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Password changed successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">My Profile</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Username</strong></label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user->name) ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Role</strong></label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-secondary">Customer</span>
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="/mini_OnShop/customer/editProfile" class="btn btn-warning">Edit Profile</a>
                        <a href="/mini_OnShop/customer/changePassword" class="btn btn-danger">Change Password</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <a href="/mini_OnShop/customer/home" class="btn btn-outline-primary w-100 mb-2">Browse Products</a>
                    <a href="/mini_OnShop/customer/cart" class="btn btn-outline-primary w-100 mb-2">My Cart</a>
                    <a href="/mini_OnShop/customer/orders" class="btn btn-outline-primary w-100">My Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
