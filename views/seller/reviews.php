<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Customer Reviews</h2>

<?php if (empty($comments)): ?>
    <div class="alert alert-info">No reviews yet on your products.</div>
<?php else: ?>
    <p class="text-muted mb-3"><?= count($comments) ?> <?= count($comments) === 1 ? 'review' : 'reviews' ?> total</p>

    <?php foreach ($comments as $comment): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">
                            <span class="text-primary"><?= htmlspecialchars($comment['writer_name']) ?></span>
                            <small class="text-muted">on</small>
                            <span class="fw-bold"><?= htmlspecialchars($comment['product_name']) ?></span>
                        </h6>
                        <small class="text-muted"><?= date('M d, Y \a\t h:i A', strtotime($comment['created_at'])) ?></small>
                    </div>
                </div>
                <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
