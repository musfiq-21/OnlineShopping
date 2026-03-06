<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Your comment has been posted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Please enter a valid comment.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Product Details -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <!-- Product Image -->
                <?php if ($product->image): ?>
                    <img src="/mini_OnShop/public/<?= htmlspecialchars($product->image) ?>" class="card-img-top" style="height: 400px; object-fit: cover;">
                <?php else: ?>
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 400px; font-size: 18px;">No Image Available</div>
                <?php endif; ?>
                
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($product->name) ?></h3>
                    
                    <p class="card-text">
                        <strong>Price:</strong> <span class="text-success fs-5">BDT <?= number_format($product->price, 2) ?></span>
                    </p>
                    
                    <p class="card-text">
                        <strong>Available Stock:</strong> <span class="badge bg-<?= $product->quantity > 0 ? 'success' : 'danger' ?>">
                            <?= $product->quantity > 0 ? $product->quantity . ' items' : 'Out of Stock' ?>
                        </span>
                    </p>

                    <?php if ($seller): ?>
                        <p class="card-text">
                            <strong>Sold by:</strong> <span class="text-primary"><?= htmlspecialchars($seller->name) ?></span>
                        </p>
                    <?php endif; ?>

                    <p class="card-text">
                        <small class="text-muted">
                            <strong>Added:</strong> <?= date('M d, Y', strtotime($product->created_at)) ?>
                        </small>
                    </p>

                    <!-- Add to Cart Form -->
                    <?php if ($product->quantity > 0): ?>
                        <form action="/mini_OnShop/customer/addToCart" method="POST" class="mt-4">
                            <input type="hidden" name="product_id" value="<?= $product->id ?>">
                            <div class="input-group mb-3">
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product->quantity ?>" class="form-control" required>
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100 mt-4" disabled>Out of Stock</button>
                    <?php endif; ?>

                    <a href="/mini_OnShop/customer/home" class="btn btn-outline-secondary w-100">Back to Products</a>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="col-md-6">
            <h4>Reviews & Comments</h4>

            <!-- Add Comment Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Share Your Review</h5>
                    <form action="/mini_OnShop/customer/addComment" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <div class="mb-3">
                            <textarea 
                                name="content" 
                                class="form-control" 
                                rows="4" 
                                placeholder="Share your experience with this product..." 
                                required
                                maxlength="1000">
                            </textarea>
                            <small class="text-muted">Max 1000 characters</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Post Review</button>
                    </form>
                </div>
            </div>

            <!-- Display Comments -->
            <div class="comments-section">
                <?php if (empty($comments)): ?>
                    <div class="alert alert-info">No reviews yet. Be the first to review this product!</div>
                <?php else: ?>
                    <h5 class="mb-3"><?= count($comments) ?> <?= count($comments) === 1 ? 'Review' : 'Reviews' ?></h5>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-3 border-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-subtitle mb-2 text-primary">
                                        <?= htmlspecialchars($comment['writer_name']) ?>
                                    </h6>
                                    <small class="text-muted">
                                        <?= date('M d, Y \a\t h:i A', strtotime($comment['created_at'])) ?>
                                    </small>
                                </div>
                                <p class="card-text"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
