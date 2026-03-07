<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-speedometer2"></i> Seller Dashboard</h2>
    <p>Welcome back! Here's your store overview.</p>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background: var(--accent-gradient);"><i class="bi bi-box-seam"></i></div>
            <div class="stat-value"><?= count($products) ?></div>
            <div class="stat-label">My Products</div>
            <a href="/mini_OnShop/seller/products" class="btn btn-outline-primary btn-sm mt-3">Manage</a>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="bi bi-graph-up"></i></div>
            <div class="stat-value"><?= count($sales) ?></div>
            <div class="stat-label">Total Sales</div>
            <a href="/mini_OnShop/seller/sales" class="btn btn-outline-success btn-sm mt-3">View</a>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><i class="bi bi-plus-circle"></i></div>
            <div class="stat-value" style="font-size: 1.2rem; margin-top: 0.5rem;">New Item</div>
            <div class="stat-label">List a new product</div>
            <a href="/mini_OnShop/seller/addProduct" class="btn btn-gradient btn-sm mt-3">Add New</a>
        </div>
    </div>
</div>

<div class="page-header">
    <h2 style="font-size: 1.3rem;"><i class="bi bi-clock-history"></i> Recent Products</h2>
</div>

<?php if (empty($products)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-box-seam d-block"></i>
            <p>No products yet. Add your first product!</p>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach (array_slice($products, 0, 6) as $product): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold"><?= htmlspecialchars($product->name) ?></h6>
                        <p class="mb-0 text-muted small">
                            <span class="price">BDT <?= number_format($product->price, 2) ?></span> &bull; Stock: <?= $product->quantity ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
