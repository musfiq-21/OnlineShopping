<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>All Products</h2>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">Product deleted!</div>
<?php endif; ?>

<?php if (empty($products)): ?>
    <p class="text-muted">No products in the system.</p>
<?php else: ?>
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
                    <td><?= htmlspecialchars($product->name) ?></td>
                    <td>$<?= number_format($product->price, 2) ?></td>
                    <td><?= $product->quantity ?></td>
                    <td><?= $product->seller_id ?></td>
                    <td>
                        <form action="/mini_OnShop/admin/deleteProduct" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
