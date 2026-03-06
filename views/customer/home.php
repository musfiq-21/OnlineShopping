<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Products</h2>

<form action="/mini_OnShop/customer/search" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search products...">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

<div class="row">
    <?php if (empty($products)): ?>
        <p class="text-muted">No products available.</p>
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
                        <p class="card-text text-success fw-bold">BDT <?= number_format($product->price, 2) ?></p>
                        <p class="card-text"><small class="text-muted">Stock: <?= $product->quantity ?></small></p>
                        <div class="d-flex gap-2 mb-3">
                            <a href="/mini_OnShop/customer/productDetail?id=<?= $product->id ?>" class="btn btn-info btn-sm flex-grow-1">Details</a>
                            <form action="/mini_OnShop/customer/addToCart" method="POST" class="flex-grow-1">
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <button type="submit" class="btn btn-primary w-100" <?= $product->quantity < 1 ? 'disabled' : '' ?>>Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
