<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>My Orders</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Order placed successfully!</div>
<?php endif; ?>

<?php if (empty($orders)): ?>
    <p class="text-muted">You haven't placed any orders yet.</p>
    <a href="/mini_OnShop/customer/home" class="btn btn-primary">Browse Products</a>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                    <td><?= $order['Quantity'] ?></td>
                    <td>BDT <?= number_format($order['Total_price'], 2) ?></td>
                    <td><?= $order['Sold_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
