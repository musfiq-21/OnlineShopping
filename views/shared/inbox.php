<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Chatbox</h2>
    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/newMessage" class="btn btn-primary">New Message</a>
</div>

<?php if (empty($conversations)): ?>
    <div class="alert alert-info">
        No conversations yet. Start one by clicking "New Message"!
    </div>
<?php else: ?>
    <div class="list-group">
        <?php foreach ($conversations as $conv): ?>
            <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/conversation?with=<?= (int)$conv['user_id'] ?>" 
               class="list-group-item list-group-item-action <?= $conv['unread_count'] > 0 ? 'list-group-item-warning' : '' ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">
                            <?= htmlspecialchars($conv['user_name']) ?>
                            <span class="badge bg-<?= $conv['user_role'] === 'admin' ? 'danger' : ($conv['user_role'] === 'seller' ? 'primary' : 'secondary') ?> ms-1">
                                <?= htmlspecialchars($conv['user_role']) ?>
                            </span>
                        </h6>
                        <p class="mb-1 text-muted small"><?= htmlspecialchars(mb_strimwidth($conv['last_message'], 0, 80, '...')) ?></p>
                    </div>
                    <div class="text-end">
                        <small class="text-muted"><?= date('M d, h:i A', strtotime($conv['last_time'])) ?></small>
                        <?php if ($conv['unread_count'] > 0): ?>
                            <br><span class="badge bg-danger mt-1"><?= (int)$conv['unread_count'] ?> new</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
