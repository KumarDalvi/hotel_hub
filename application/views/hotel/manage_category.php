<form action="<?= base_url() ?>hotel/save_category" method="post">
    <div class="container p-4 bg-white shadow rounded">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3 class="text-primary fw-bold">➕ Add New Category</h3>
            </div>
            <div class="col-md-10">
                <label class="fw-semibold">Enter Category Name</label>
                <input type="text" name="category_name" class="form-control border-primary shadow-sm" required placeholder="📂 Category Name">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100 shadow-sm fw-bold">💾 Save</button>
            </div>
        </div>
    </div>
</form>

<div class="container p-4 bg-white mt-3 shadow rounded">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h3 class="text-danger fw-bold">📂 Manage Categories</h3>

            <!-- Table Wrapper for Mobile Scroll -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>📁 Category Name</th>
                            <th>⚙️ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cats as $key => $row): ?>
                            <tr>
                                <td class="fw-bold"><?= $key + 1 ?></td>
                                <td class="text-primary fw-semibold"><?= $row['category_name'] ?></td>
                                <td>
                                    <a href="<?= base_url() ?>hotel/edit_category?category_id=<?= $row['category_id'] ?>" class="btn btn-sm btn-warning shadow-sm">
                                        ✏️ Edit
                                    </a>
                                    <a href="<?= base_url() ?>hotel/delete_category?category_id=<?= $row['category_id'] ?>" 
                                       class="btn btn-sm btn-danger shadow-sm" 
                                       onclick="return confirm('Are you sure you want to delete this category?')">
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

