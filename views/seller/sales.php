<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-graph-up"></i> Sales History</h2>
</div>

<?php if (empty($sales)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-graph-down d-block"></i>
            <p>No sales yet.</p>
            <a href="/mini_OnShop/seller/dashboard" class="btn btn-gradient">Back to Dashboard</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Buyer</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($sale['product_name']) ?></td>
                        <td><?= htmlspecialchars($sale['buyer_name']) ?></td>
                        <td><?= $sale['Quantity'] ?></td>
                        <td class="fw-bold">BDT <?= number_format($sale['Total_price'], 2) ?></td>
                        <td><i class="bi bi-calendar3 me-1"></i><?= $sale['Sold_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="/mini_OnShop/seller/dashboard" class="btn btn-outline-secondary mt-3"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
