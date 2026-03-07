<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-receipt"></i> My Orders</h2>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><i class="bi bi-check-circle"></i> Order placed successfully!</div>
<?php endif; ?>

<?php if (empty($orders)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-receipt-cutoff d-block"></i>
            <p>You haven't placed any orders yet.</p>
            <a href="/mini_OnShop/customer/home" class="btn btn-gradient">Browse Products</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
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
                        <td class="fw-semibold"><?= htmlspecialchars($order['product_name']) ?></td>
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
