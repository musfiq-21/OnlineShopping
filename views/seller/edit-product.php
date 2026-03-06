<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Edit Product</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Please fill all required fields with valid values!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/mini_OnShop/seller/handleEditProduct" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">

                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Product Name *</strong></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product->name) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label"><strong>Price *</strong></label>
                            <input type="number" class="form-control" id="price" name="price" value="<?= $product->price ?>" step="0.01" min="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label"><strong>Product Image</strong></label>
                            <div class="mb-2">
                                <?php if ($product->image): ?>
                                    <p><strong>Current Image:</strong></p>
                                    <img src="/mini_OnShop/public/<?= htmlspecialchars($product->image) ?>" style="max-width: 200px; max-height: 200px; object-fit: cover;" class="border">
                                <?php else: ?>
                                    <p class="text-muted">No image uploaded</p>
                                <?php endif; ?>
                            </div>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Upload a new image to replace the current one (optional)</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <a href="/mini_OnShop/seller/products" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Product Info</h5>
                </div>
                <div class="card-body">
                    <p><strong>Product ID:</strong> <?= $product->id ?></p>
                    <p><strong>Stock:</strong> <?= $product->quantity ?> units</p>
                    <p><strong>Created:</strong> <?= date('M d, Y', strtotime($product->created_at)) ?></p>
                    <a href="/mini_OnShop/seller/products" class="btn btn-outline-secondary w-100">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
