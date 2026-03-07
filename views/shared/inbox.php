<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h2><i class="bi bi-chat-dots"></i> Chatbox</h2>
    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/newMessage" class="btn btn-gradient"><i class="bi bi-plus-circle"></i> New Message</a>
</div>

<?php if (empty($conversations)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-chat-square-dots d-block"></i>
            <p>No conversations yet.</p>
            <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/newMessage" class="btn btn-gradient">Start a Conversation</a>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="list-group list-group-flush">
            <?php foreach ($conversations as $conv): ?>
                <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/conversation?with=<?= (int)$conv['user_id'] ?>"
                    class="list-group-item list-group-item-action <?= $conv['unread_count'] > 0 ? 'list-group-item-warning' : '' ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold">
                                <?= htmlspecialchars($conv['user_name']) ?>
                                <span class="badge bg-<?= $conv['user_role'] === 'admin' ? 'danger' : ($conv['user_role'] === 'seller' ? 'primary' : 'secondary') ?> ms-1">
                                    <?= ucfirst(htmlspecialchars($conv['user_role'])) ?>
                                </span>
                            </h6>
                            <p class="mb-0 text-muted small"><?= htmlspecialchars(mb_strimwidth($conv['last_message'], 0, 80, '...')) ?></p>
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
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
