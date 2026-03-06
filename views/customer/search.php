<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Search Results: "<?= htmlspecialchars($_GET['q'] ?? '') ?>"</h2>

<form action="/mini_OnShop/customer/search" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Search products...">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

<div class="row">
    <?php if (empty($products)): ?>
        <p class="text-muted">No products found.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($product->image): ?>
                        <img src="/mini_OnShop/public/<?= htmlspecialchars($product->image) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">No Image</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                        <p class="card-text text-success fw-bold">$<?= number_format($product->price, 2) ?></p>
                        <p class="card-text"><small class="text-muted">Stock: <?= $product->quantity ?></small></p>
                        <form action="/mini_OnShop/customer/addToCart" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product->id ?>">
                            <div class="input-group">
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product->quantity ?>" class="form-control">
                                <button type="submit" class="btn btn-primary" <?= $product->quantity < 1 ? 'disabled' : '' ?>>Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<a href="/mini_OnShop/customer/home" class="btn btn-secondary">Back to All Products</a>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
