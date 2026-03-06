<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Manage Users</h2>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">User deleted!</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] === 'self'): ?>
    <div class="alert alert-danger">Cannot delete your own account!</div>
<?php endif; ?>

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
                <td><?= htmlspecialchars($user->name) ?></td>
                <td>
                    <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : ($user->role === 'seller' ? 'primary' : 'secondary') ?>">
                        <?= $user->role ?>
                    </span>
                </td>
                <td>
                    <?php if ($user->id !== $_SESSION['user_id']): ?>
                        <form action="/mini_OnShop/admin/deleteUser" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">(You)</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
