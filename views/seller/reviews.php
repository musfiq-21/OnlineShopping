<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-star"></i> Customer Reviews</h2>
    <?php if (!empty($comments)): ?>
        <p><?= count($comments) ?> <?= count($comments) === 1 ? 'review' : 'reviews' ?> on your products</p>
    <?php endif; ?>
</div>

<?php if (empty($comments)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-chat-square-text d-block"></i>
            <p>No reviews yet on your products.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($comments as $comment): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">
                            <i class="bi bi-person-circle me-1" style="color: var(--accent);"></i>
                            <span style="color: var(--accent);"><?= htmlspecialchars($comment['writer_name']) ?></span>
                            <small class="text-muted mx-1">on</small>
                            <span class="fw-bold"><?= htmlspecialchars($comment['product_name']) ?></span>
                        </h6>
                        <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= date('M d, Y \a\t h:i A', strtotime($comment['created_at'])) ?></small>
                    </div>
                </div>
                <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
