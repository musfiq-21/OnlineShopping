<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="display-4"><?= $totalUsers ?></p>
                <a href="/mini_OnShop/admin/users" class="btn btn-light btn-sm">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <p class="display-4"><?= $totalProducts ?></p>
                <a href="/mini_OnShop/admin/products" class="btn btn-light btn-sm">View</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="display-4"><?= count($recentOrders) ?></p>
                <a href="/mini_OnShop/admin/orders" class="btn btn-light btn-sm">View</a>
            </div>
        </div>
    </div>
</div>

<h4>Recent Orders</h4>
<?php if (empty($recentOrders)): ?>
    <p class="text-muted">No orders yet.</p>
<?php else: ?>
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
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                    <td><?= htmlspecialchars($order['buyer_name']) ?></td>
                    <td>BDT <?= number_format($order['Total_price'], 2) ?></td>
                    <td><?= $order['Sold_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
