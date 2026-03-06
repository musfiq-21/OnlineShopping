<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Sales History</h2>

<?php if (empty($sales)): ?>
    <p class="text-muted">No sales yet.</p>
<?php else: ?>
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
                    <td><?= htmlspecialchars($sale['product_name']) ?></td>
                    <td><?= htmlspecialchars($sale['buyer_name']) ?></td>
                    <td><?= $sale['Quantity'] ?></td>
                    <td>BDT <?= number_format($sale['Total_price'], 2) ?></td>
                    <td><?= $sale['Sold_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="/mini_OnShop/seller/dashboard" class="btn btn-secondary">Back to Dashboard</a>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
