<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-search"></i> Search Results</h2>
    <p>Showing results for "<?= htmlspecialchars($_GET['q'] ?? '') ?>"</p>
</div>

<div class="card mb-4">
    <div class="card-body p-3">
        <form action="/mini_OnShop/customer/search" method="GET">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Search products...">
                <button class="btn btn-gradient" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <?php if (empty($products)): ?>
        <div class="col-12">
            <div class="card">
                <div class="empty-state">
                    <i class="bi bi-search d-block"></i>
                    <p>No products found.</p>
                    <a href="/mini_OnShop/customer/home" class="btn btn-gradient">Back to All Products</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <?php if ($product->image): ?>
                        <img src="/mini_OnShop/public/<?= htmlspecialchars($product->image) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="no-image"><i class="bi bi-image me-2"></i>No Image</div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($product->name) ?></h5>
                        <p class="price mb-1">BDT <?= number_format($product->price, 2) ?></p>
                        <p class="text-muted small mb-3"><i class="bi bi-box"></i> Stock: <?= $product->quantity ?></p>
                        <div class="d-flex gap-2 mt-auto">
                            <a href="/mini_OnShop/customer/productDetail?id=<?= $product->id ?>" class="btn btn-outline-primary btn-sm flex-grow-1"><i class="bi bi-eye"></i> Details</a>
                            <form action="/mini_OnShop/customer/addToCart" method="POST" class="flex-grow-1">
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <button type="submit" class="btn btn-gradient btn-sm w-100" <?= $product->quantity < 1 ? 'disabled' : '' ?>><i class="bi bi-cart-plus"></i> Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (!empty($products)): ?>
    <a href="/mini_OnShop/customer/home" class="btn btn-outline-secondary mt-2"><i class="bi bi-arrow-left"></i> Back to All Products</a>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
