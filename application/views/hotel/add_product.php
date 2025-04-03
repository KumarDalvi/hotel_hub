<form action="<?= base_url() ?>hotel/save_product" method="post" enctype="multipart/form-data">
    <div class="container p-4 bg-white shadow rounded">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3 class="text-success fw-bold">🛒 Add New Product</h3>
            </div>

            <div class="col-md-5 mb-3">
                <label class="fw-semibold">📂 Select Category</label>
                <select class="form-select border-success shadow-sm" name="category_id" required>
                    <option value="" selected disabled>🔽 Choose Category</option>
                    <?php foreach ($cats as $row): ?>
                        <option value="<?= $row['category_id'] ?>">🗂️ <?= $row['category_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-7 mb-3">
                <label class="fw-semibold">📦 Enter Product Name</label>
                <input type="text" class="form-control border-success shadow-sm" name="product_name" required placeholder="📝 Product Name">
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">💰 Price</label>
                <input type="number" class="form-control border-success shadow-sm" name="product_price" required placeholder="₹ Enter Price">
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">🖼️ Upload Image</label>
                <input type="file" class="form-control border-success shadow-sm" name="product_image" required>
            </div>

            <div class="col-md-12 text-center">
                <button class="btn btn-success px-4 py-2 fw-bold shadow-sm">💾 Save Product</button>
            </div>
        </div>
    </div>
</form>