<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h2><i class="bi bi-box-seam"></i> My Products</h2>
    <a href="/mini_OnShop/seller/addProduct" class="btn btn-gradient"><i class="bi bi-plus-circle"></i> Add New Product</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Product added successfully!</div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Product updated successfully!</div>
<?php endif; ?>

<?php if (empty($products)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-box-seam d-block"></i>
            <p>No products yet.</p>
            <a href="/mini_OnShop/seller/addProduct" class="btn btn-gradient">Add Your First Product</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($product->name) ?></td>
                        <td>
                            <form action="/mini_OnShop/seller/updatePrice" method="POST" class="d-flex gap-1 align-items-center">
                                <input type="hidden" name="id" value="<?= $product->id ?>">
                                <input type="number" name="price" step="0.01" value="<?= $product->price ?>" style="width: 90px;" class="form-control form-control-sm">
                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-check"></i></button>
                            </form>
                        </td>
                        <td>
                            <form action="/mini_OnShop/seller/restock" method="POST" class="d-flex gap-1 align-items-center">
                                <input type="hidden" name="id" value="<?= $product->id ?>">
                                <span class="badge bg-secondary me-1"><?= $product->quantity ?></span>
                                <input type="number" name="quantity" value="10" min="1" style="width: 70px;" class="form-control form-control-sm">
                                <button type="submit" class="btn btn-sm btn-outline-info"><i class="bi bi-plus"></i></button>
                            </form>
                        </td>
                        <td>
                            <a href="/mini_OnShop/seller/editProduct?id=<?= $product->id ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form action="/mini_OnShop/seller/deleteProduct" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
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
