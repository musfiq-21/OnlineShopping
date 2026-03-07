<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-cart3"></i> Shopping Cart</h2>
</div>

<?php if (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
    <div class="alert alert-warning"><i class="bi bi-exclamation-triangle"></i> Your cart is empty!</div>
<?php endif; ?>

<?php if (empty($items)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-cart-x d-block"></i>
            <p>Your cart is empty.</p>
            <a href="/mini_OnShop/customer/home" class="btn btn-gradient">Browse Products</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
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
                        <td class="fw-semibold"><?= htmlspecialchars($item['product_name']) ?></td>
                        <td>BDT <?= number_format($item['unit_price'], 2) ?></td>
                        <td><?= $item['Quantity'] ?></td>
                        <td class="fw-bold">BDT <?= number_format($item['unit_price'] * $item['Quantity'], 2) ?></td>
                        <td>
                            <form action="/mini_OnShop/customer/removeFromCart" method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['Product'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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
    </div>
    <div class="d-flex gap-2 mt-3">
        <a href="/mini_OnShop/customer/home" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
        <form action="/mini_OnShop/customer/checkout" method="POST">
            <button type="submit" class="btn btn-gradient"><i class="bi bi-bag-check"></i> Checkout</button>
        </form>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
