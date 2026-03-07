<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-box-seam"></i> All Products</h2>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Product deleted!</div>
<?php endif; ?>

<?php if (empty($products)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-box-seam d-block"></i>
            <p>No products in the system.</p>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Seller ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product->id ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($product->name) ?></td>
                        <td>BDT <?= number_format($product->price, 2) ?></td>
                        <td><span class="badge bg-<?= $product->quantity > 0 ? 'success' : 'danger' ?>"><?= $product->quantity ?></span></td>
                        <td><?= $product->seller_id ?></td>
                        <td>
                            <form action="/mini_OnShop/admin/deleteProduct" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                <input type="hidden" name="id" value="<?= $product->id ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
