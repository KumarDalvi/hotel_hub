<?php
// Check if session variables exist before using them


$hotel_id = $_SESSION['hotel_id'];
$category_id = $product[0]['category_id'];

// Fetch category ensuring the hotel_id condition to prevent mismatches
$query = $this->db->where("category_id", $category_id)
                  ->where("hotel_id", $hotel_id) // Ensures category belongs to the hotel
                  ->get("category");

if ($query->num_rows() > 0) {
    $category = $query->row_array();
    $selected_category_name = $category['category_name'];
} else {
    $selected_category_name = "Unknown Category";
}

// Fetch all categories for the dropdown, filtering by hotel_id
$categories_query = $this->db->where("hotel_id", $hotel_id)->get("category");
$categories = $categories_query->result_array();
?>

<form action="<?= base_url() ?>hotel/update_product" method="post" enctype="multipart/form-data">
    <div class="container p-4 bg-white shadow rounded">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3 class="text-primary fw-bold">✏️ Edit Product</h3>
            </div>

            <input type="hidden" name="product_id" value="<?= $product[0]['product_id'] ?>">

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">📂 Select Category</label>
                <select class="form-select border-primary shadow-sm" name="category_id" required>
                    <option value="<?= $category_id ?>" selected><?= $selected_category_name ?></option>
                    <?php foreach ($categories as $row) : ?>
                        <?php if ($row['category_id'] != $category_id) : ?>
                            <option value="<?= $row['category_id'] ?>"> <?= $row['category_name'] ?> </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">🛒 Product Name</label>
                <input type="text" class="form-control border-primary shadow-sm" name="product_name" value="<?= $product[0]['product_name'] ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">💰 Price (₹)</label>
                <input type="number" class="form-control border-primary shadow-sm" name="product_price" value="<?= $product[0]['product_price'] ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">📷 Upload New Image</label>
                <input type="file" class="form-control border-primary shadow-sm" name="product_image">
            </div>

            <div class="col-md-12 mb-3 text-center">
                <label class="fw-semibold">🖼️ Current Image</label><br>
                <div class="border rounded p-2 d-inline-block bg-light shadow-sm">
                    <img src="<?= base_url() ?>/uploads/<?= $product[0]['product_image'] ?>" class="rounded shadow-sm" width="120">
                </div>
                <input type="hidden" name="old_product_image" value="<?= $product[0]['product_image'] ?>">
            </div>

            <div class="col-12 text-center mt-4">
                <button class="btn btn-primary px-5 py-2 fw-bold shadow-sm">💾 Update Product</button>
            </div>
        </div>
    </div>
</form>


