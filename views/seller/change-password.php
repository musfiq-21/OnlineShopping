<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-shield-lock"></i> Change Password</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body p-4">
                <?php if (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> All fields are required!</div>
                <?php endif; ?>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'incorrect'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> Current password is incorrect!</div>
                <?php endif; ?>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'mismatch'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> New passwords do not match!</div>
                <?php endif; ?>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'weak'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> Password must be at least 5 characters!</div>
                <?php endif; ?>

                <form action="/mini_OnShop/seller/handleChangePassword" method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="5" required>
                        </div>
                        <small class="text-muted">At least 5 characters</small>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="5" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient flex-grow-1"><i class="bi bi-check-lg"></i> Change Password</button>
                        <a href="/mini_OnShop/seller/profile" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
