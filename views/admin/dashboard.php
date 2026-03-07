<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
    <p>System overview and recent activity</p>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background: var(--accent-gradient);"><i class="bi bi-people"></i></div>
            <div class="stat-value"><?= $totalUsers ?></div>
            <div class="stat-label">Total Users</div>
            <a href="/mini_OnShop/admin/users" class="btn btn-outline-primary btn-sm mt-3">Manage</a>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="bi bi-box-seam"></i></div>
            <div class="stat-value"><?= $totalProducts ?></div>
            <div class="stat-label">Total Products</div>
            <a href="/mini_OnShop/admin/products" class="btn btn-outline-success btn-sm mt-3">View</a>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><i class="bi bi-receipt"></i></div>
            <div class="stat-value"><?= count($recentOrders) ?></div>
            <div class="stat-label">Total Orders</div>
            <a href="/mini_OnShop/admin/orders" class="btn btn-outline-warning btn-sm mt-3">View</a>
        </div>
    </div>
</div>

<div class="page-header">
    <h2 style="font-size: 1.3rem;"><i class="bi bi-clock-history"></i> Recent Orders</h2>
</div>

<?php if (empty($recentOrders)): ?>
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
                    <th>Product</th>
                    <th>Buyer</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($recentOrders, 0, 5) as $order): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                        <td class="fw-bold">BDT <?= number_format($order['Total_price'], 2) ?></td>
                        <td><i class="bi bi-calendar3 me-1"></i><?= $order['Sold_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
