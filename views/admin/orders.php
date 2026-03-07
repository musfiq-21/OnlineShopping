<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-receipt"></i> All Orders</h2>
</div>

<?php if (empty($orders)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-receipt-cutoff d-block"></i>
            <p>No orders yet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
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
                        <td class="fw-semibold"><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                        <td><?= $order['Quantity'] ?></td>
                        <td class="fw-bold">BDT <?= number_format($order['Total_price'], 2) ?></td>
                        <td><i class="bi bi-calendar3 me-1"></i><?= $order['Sold_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
