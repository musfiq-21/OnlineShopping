<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2><i class="bi bi-plus-circle"></i> Add New Product</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body p-4">
                <form action="/mini_OnShop/seller/handleAddProduct" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (BDT)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                            <input type="number" name="price" step="0.01" min="0" class="form-control" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-stack"></i></span>
                            <input type="number" name="quantity" min="0" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient flex-grow-1"><i class="bi bi-check-lg"></i> Add Product</button>
                        <a href="/mini_OnShop/seller/products" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
