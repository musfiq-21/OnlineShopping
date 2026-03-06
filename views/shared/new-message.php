<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>New Message</h4>
    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/inbox" class="btn btn-outline-secondary btn-sm">Back to Inbox</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="list-group">
            <?php if (empty($users)): ?>
                <p class="text-muted">No other users found.</p>
            <?php else: ?>
                <?php foreach ($users as $u): ?>
                    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/conversation?with=<?= (int)$u->id ?>" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($u->name) ?></strong>
                        </div>
                        <span class="badge bg-<?= $u->role === 'admin' ? 'danger' : ($u->role === 'seller' ? 'primary' : 'secondary') ?>">
                            <?= htmlspecialchars($u->role) ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
