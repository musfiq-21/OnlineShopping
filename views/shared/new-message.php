<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h2><i class="bi bi-pencil-square"></i> New Message</h2>
    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/inbox" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Inbox</a>
</div>

<div class="card">
    <div class="card-header gradient-header">
        <h5 class="mb-0"><i class="bi bi-people me-2"></i>Choose a person to message</h5>
    </div>
    <div class="list-group list-group-flush">
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <i class="bi bi-people d-block"></i>
                <p>No users available to message.</p>
            </div>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
                <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/conversation?with=<?= (int)$u->id ?>"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;border-radius:50%;background:var(--accent-gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.85rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <strong><?= htmlspecialchars($u->name) ?></strong>
                    </div>
                    <span class="badge bg-<?= $u->role === 'admin' ? 'danger' : ($u->role === 'seller' ? 'primary' : 'secondary') ?>">
                        <?= ucfirst(htmlspecialchars($u->role)) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
