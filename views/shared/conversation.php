<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>
        Chat with <?= htmlspecialchars($otherUser->name) ?>
        <span class="badge bg-<?= $otherUser->role === 'admin' ? 'danger' : ($otherUser->role === 'seller' ? 'primary' : 'secondary') ?>">
            <?= htmlspecialchars($otherUser->role) ?>
        </span>
    </h4>
    <a href="/mini_OnShop/<?= htmlspecialchars($role) ?>/inbox" class="btn btn-outline-secondary btn-sm">Back to Inbox</a>
</div>

<div class="card">
    <div class="card-body" id="chat-messages" style="height: 450px; overflow-y: auto; background: #f8f9fa;">
        <?php if (empty($messages)): ?>
            <p class="text-muted text-center mt-5">No messages yet. Send the first one!</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <?php $isMine = (int)$msg['sender_id'] === $_SESSION['user_id']; ?>
                <div class="d-flex mb-3 <?= $isMine ? 'justify-content-end' : 'justify-content-start' ?>">
                    <div class="p-3 rounded-3 shadow-sm" style="max-width: 70%; <?= $isMine ? 'background: #0d6efd; color: white;' : 'background: white;' ?>">
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

    <div class="card-footer">
        <form action="/mini_OnShop/<?= htmlspecialchars($role) ?>/sendMessage" method="POST">
            <input type="hidden" name="receiver_id" value="<?= (int)$otherUser->id ?>">
            <div class="input-group">
                <textarea name="content" class="form-control" rows="2" placeholder="Type your message..." required maxlength="2000"></textarea>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-scroll to bottom of chat
    const chatBox = document.getElementById('chat-messages');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
