<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Shop name cannot be empty!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            This shop name is already taken!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/mini_OnShop/seller/handleEditProfile" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Shop Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <a href="/mini_OnShop/seller/profile" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
