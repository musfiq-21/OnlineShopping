<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h2 style="font-size: 1.3rem;">
        <i class="bi bi-chat-dots"></i> Chat with <?= htmlspecialchars($otherUser->name) ?>
        <span class="badge bg-<?= $otherUser->role === 'admin' ? 'danger' : ($otherUser->role === 'seller' ? 'primary' : 'secondary') ?>">
            <?= ucfirst(htmlspecialchars($otherUser->role)) ?>
        </span>
    </h2>
    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/inbox" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Inbox</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="chat-container" id="chat-messages">
            <?php if (empty($messages)): ?>
                <div class="empty-state">
                    <i class="bi bi-chat-square d-block"></i>
                    <p>No messages yet. Send the first one!</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <?php $isMine = (int)$msg['sender_id'] === $_SESSION['user_id']; ?>
                    <div class="d-flex mb-3 <?= $isMine ? 'justify-content-end' : 'justify-content-start' ?>">
                        <div class="<?= $isMine ? 'chat-bubble-mine' : 'chat-bubble-other' ?>">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="small"><?= $isMine ? 'You' : htmlspecialchars($msg['sender_name']) ?></strong>
                                <small class="ms-3 <?= $isMine ? 'text-white-50' : 'text-muted' ?>"><?= date('h:i A', strtotime($msg['sent_at'])) ?></small>
                            </div>
                            <div><?= nl2br(htmlspecialchars($msg['content'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-footer bg-transparent border-top" style="border-radius: 0 0 16px 16px;">
        <form action="/mini_OnShop/<?= htmlspecialchars($role) ?>/sendMessage" method="POST">
            <input type="hidden" name="receiver_id" value="<?= (int)$otherUser->id ?>">
            <div class="input-group">
                <textarea name="content" class="form-control" rows="2" placeholder="Type your message..." required maxlength="2000" style="border-radius: 8px 0 0 8px;"></textarea>
                <button type="submit" class="btn btn-gradient" style="border-radius: 0 8px 8px 0;"><i class="bi bi-send"></i></button>
            </div>
        </form>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-messages');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
