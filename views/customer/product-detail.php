<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-box-seam"></i> Product Details</h2>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Your comment has been posted successfully!</div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> Please enter a valid comment.</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <?php if ($product->image): ?>
                <img src="/mini_OnShop/public/<?= htmlspecialchars($product->image) ?>" class="card-img-top" style="height: 400px; object-fit: cover; border-radius: 16px 16px 0 0;">
            <?php else: ?>
                <div class="no-image" style="height: 400px; font-size: 1.1rem;"><i class="bi bi-image me-2"></i>No Image Available</div>
            <?php endif; ?>
            <div class="card-body">
                <h3 class="card-title fw-bold"><?= htmlspecialchars($product->name) ?></h3>
                <p class="price mb-2" style="font-size: 1.3rem;">BDT <?= number_format($product->price, 2) ?></p>
                <p class="mb-2">
                    <span class="badge bg-<?= $product->quantity > 0 ? 'success' : 'danger' ?>">
                        <?= $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of Stock' ?>
                    </span>
                </p>
                <?php if ($seller): ?>
                    <p class="text-muted mb-2"><i class="bi bi-shop me-1"></i> Sold by <strong><?= htmlspecialchars($seller->name) ?></strong></p>
                <?php endif; ?>
                <p class="text-muted small"><i class="bi bi-calendar3 me-1"></i> Added <?= date('M d, Y', strtotime($product->created_at)) ?></p>

                <?php if ($product->quantity > 0): ?>
                    <form action="/mini_OnShop/customer/addToCart" method="POST" class="mt-3">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <div class="input-group mb-3">
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product->quantity ?>" class="form-control" required>
                            <button type="submit" class="btn btn-gradient"><i class="bi bi-cart-plus"></i> Add to Cart</button>
                        </div>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary w-100 mt-3" disabled>Out of Stock</button>
                <?php endif; ?>

                <a href="/mini_OnShop/customer/home" class="btn btn-outline-secondary w-100 mt-2"><i class="bi bi-arrow-left"></i> Back to Products</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header gradient-header">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Share Your Review</h5>
            </div>
            <div class="card-body">
                <form action="/mini_OnShop/customer/addComment" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" placeholder="Share your experience with this product..." required maxlength="1000"></textarea>
                        <small class="text-muted">Max 1000 characters</small>
                    </div>
                    <button type="submit" class="btn btn-gradient w-100"><i class="bi bi-send"></i> Post Review</button>
                </form>
            </div>
        </div>

        <h5 class="text-white mb-3">
            <i class="bi bi-chat-square-text me-1"></i>
            <?= empty($comments) ? 'No Reviews Yet' : count($comments) . ' ' . (count($comments) === 1 ? 'Review' : 'Reviews') ?>
        </h5>

        <?php if (empty($comments)): ?>
            <div class="card">
                <div class="empty-state" style="padding: 2rem;">
                    <i class="bi bi-chat-square d-block"></i>
                    <p>Be the first to review this product!</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0" style="color: var(--accent);"><?= htmlspecialchars($comment['writer_name']) ?></h6>
                            <small class="text-muted"><?= date('M d, Y', strtotime($comment['created_at'])) ?></small>
                        </div>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
