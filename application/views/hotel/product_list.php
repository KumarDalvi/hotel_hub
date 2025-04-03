<div class="container p-4 bg-white mt-3 shadow rounded">
    <div class="row">
        <div class="col-md-12 mb-3">
            <form action="<?= base_url() ?>hotel/product_list" method="get" class="d-flex mb-3">
                <input type="text" name="search" class="form-control me-2" placeholder="🔍 Search products..." style="max-width: 300px;">
                <button class="btn btn-primary">Search</button>
            </form>

            <h3 class="mb-3">📦 Product List</h3>

            <!-- Table Wrapper for Mobile Scroll -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>📁 Category</th>
                            <th>📦 Product Name</th>
                            <th>💰 Price</th>
                            <th>🖼️ Image</th>
                            <th>⚙️ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $key => $row): ?>
                            <tr>
                                <td class="fw-bold"><?= $key + 1 ?></td>
                                <td><?= $row['category_name'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td class="fw-bold text-success">₹<?= number_format($row['product_price'], 2) ?></td>
                                <td>
                                    <img src="<?= base_url('uploads/' . $row['product_image']); ?>" 
                                         alt="Product Image" 
                                         class="img-thumbnail shadow-sm" 
                                         style="max-width: 80px; height: auto;">
                                </td>
                                <td>
                                    <a href="<?= base_url() ?>hotel/edit_product?product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning">
                                        ✏️ Edit
                                    </a>
                                    <a href="<?= base_url() ?>hotel/delete_product?product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                        ❌ Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> <!-- End Table Wrapper -->
        </div>
    </div>
</div>