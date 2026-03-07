<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-pencil-square"></i> Edit Product</h2>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-body p-4">
                <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-circle"></i> Please fill all required fields with valid values!</div>
                <?php endif; ?>

                <form action="/mini_OnShop/seller/handleEditProduct" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product->name) ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (BDT)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                            <input type="number" class="form-control" id="price" name="price" value="<?= $product->price ?>" step="0.01" min="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <div class="mb-2">
                            <?php if ($product->image): ?>
                                <p class="text-muted small mb-1">Current Image:</p>
                                <img src="/mini_OnShop/public/<?= htmlspecialchars($product->image) ?>" style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 12px;">
                            <?php else: ?>
                                <p class="text-muted">No image uploaded</p>
                            <?php endif; ?>
                        </div>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Upload a new image to replace the current one (optional)</small>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient flex-grow-1"><i class="bi bi-check-lg"></i> Save Changes</button>
                        <a href="/mini_OnShop/seller/products" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header gradient-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Product Info</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Product ID:</strong> <?= $product->id ?></p>
                <p class="mb-2"><strong>Stock:</strong> <span class="badge bg-secondary"><?= $product->quantity ?> units</span></p>
                <p class="mb-3"><strong>Created:</strong> <?= date('M d, Y', strtotime($product->created_at)) ?></p>
                <a href="/mini_OnShop/seller/products" class="quick-link"><i class="bi bi-arrow-left"></i> Back to Products</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
