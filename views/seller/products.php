<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>My Products</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Product added successfully!</div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
    <div class="alert alert-success">Product updated successfully!</div>
<?php endif; ?>

<a href="/mini_OnShop/seller/addProduct" class="btn btn-success mb-3">Add New Product</a>

<?php if (empty($products)): ?>
    <p class="text-muted">No products yet.</p>
<?php else: ?>
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
                    <td><?= htmlspecialchars($product->name) ?></td>
                    <td>
                        <form action="/mini_OnShop/seller/updatePrice" method="POST" class="d-flex gap-1">
                            <input type="hidden" name="id" value="<?= $product->id ?>">
                            <input type="number" name="price" step="0.01" value="<?= $product->price ?>" style="width: 80px;" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="/mini_OnShop/seller/restock" method="POST" class="d-flex gap-1">
                            <input type="hidden" name="id" value="<?= $product->id ?>">
                            <span class="me-2"><?= $product->quantity ?></span>
                            <input type="number" name="quantity" value="10" min="1" style="width: 60px;" class="form-control form-control-sm">
                            <button type="submit" class="btn btn-sm btn-outline-info">Add</button>
                        </form>
                    </td>
                    <td>
                        <a href="/mini_OnShop/seller/editProduct?id=<?= $product->id ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                        <form action="/mini_OnShop/seller/deleteProduct" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            <input type="hidden" name="id" value="<?= $product->id ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
