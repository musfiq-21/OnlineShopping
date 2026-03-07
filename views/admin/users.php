<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-people"></i> Manage Users</h2>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> User deleted!</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] === 'self'): ?>
    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> Cannot delete your own account!</div>
<?php endif; ?>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($user->name) ?></td>
                    <td>
                        <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : ($user->role === 'seller' ? 'primary' : 'secondary') ?>">
                            <?= ucfirst($user->role) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($user->id !== $_SESSION['user_id']): ?>
                            <form action="/mini_OnShop/admin/deleteUser" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted small"><i class="bi bi-person-check"></i> You</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
