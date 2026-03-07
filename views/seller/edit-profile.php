<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-pencil-square"></i> Edit Profile</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body p-4">
                <?php if (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> Shop name cannot be empty!</div>
                <?php endif; ?>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> This shop name is already taken!</div>
                <?php endif; ?>

                <form action="/mini_OnShop/seller/handleEditProfile" method="POST">
                    <div class="mb-4">
                        <label for="name" class="form-label">Shop Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient flex-grow-1"><i class="bi bi-check-lg"></i> Save Changes</button>
                        <a href="/mini_OnShop/seller/profile" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
