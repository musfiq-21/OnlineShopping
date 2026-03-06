<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>All Orders</h2>

<?php if (empty($orders)): ?>
    <p class="text-muted">No orders yet.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Buyer</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['ID'] ?></td>
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                    <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                    <td><?= $order['Quantity'] ?></td>
                    <td>BDT <?= number_format($order['Total_price'], 2) ?></td>
                    <td><?= $order['Sold_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
