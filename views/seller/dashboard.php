<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Seller Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">My Products</h5>
                <p class="display-4"><?= count($products) ?></p>
                <a href="/mini_OnShop/seller/products" class="btn btn-primary btn-sm">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Sales</h5>
                <p class="display-4"><?= count($sales) ?></p>
                <a href="/mini_OnShop/seller/sales" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Add Product</h5>
                <p class="text-muted">List a new item</p>
                <a href="/mini_OnShop/seller/addProduct" class="btn btn-success btn-sm">Add New</a>
            </div>
        </div>
    </div>
</div>

<h4>Recent Products</h4>
<?php if (empty($products)): ?>
    <p class="text-muted">No products yet.</p>
<?php else: ?>
    <div class="row">
        <?php foreach (array_slice($products, 0, 6) as $product): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6><?= htmlspecialchars($product->name) ?></h6>
                        <p class="mb-0">BDT <?= number_format($product->price, 2) ?> | Stock: <?= $product->quantity ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
