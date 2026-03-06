<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Shopping Cart</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
    <div class="alert alert-warning">Your cart is empty!</div>
<?php endif; ?>

<?php if (empty($items)): ?>
    <p class="text-muted">Your cart is empty.</p>
    <a href="/mini_OnShop/customer/home" class="btn btn-primary">Browse Products</a>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>BDT <?= number_format($item['unit_price'], 2) ?></td>
                    <td><?= $item['Quantity'] ?></td>
                    <td>BDT <?= number_format($item['unit_price'] * $item['Quantity'], 2) ?></td>
                    <td>
                        <form action="/mini_OnShop/customer/removeFromCart" method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?= $item['Product'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>BDT <?= number_format($total, 2) ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    
    <div class="d-flex gap-2">
        <a href="/mini_OnShop/customer/home" class="btn btn-secondary">Continue Shopping</a>
        <form action="/mini_OnShop/customer/checkout" method="POST">
            <button type="submit" class="btn btn-success">Checkout</button>
        </form>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
