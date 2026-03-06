<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Add New Product</h2>

<form action="/mini_OnShop/seller/handleAddProduct" method="POST" enctype="multipart/form-data" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Price ($)</label>
        <input type="number" name="price" step="0.01" min="0" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" min="0" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-success">Add Product</button>
    <a href="/mini_OnShop/seller/products" class="btn btn-secondary">Cancel</a>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
