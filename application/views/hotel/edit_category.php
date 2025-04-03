<?php
$default_path = base_url()."assets/img/icons/icon-48x48.png";	
$hotel_image_path = base_url()."uploads/".$_SESSION['hotel_image'];	
?>

<div class="container p-4 bg-white mt-3 shadow rounded">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h3 class="fw-bold text-primary">✏️ Edit Category</h3>
            
            <form action="<?= base_url() ?>hotel/update_category" method="post" class="mt-3">
                <input type="hidden" name="category_id" value="<?= $category_data[0]['category_id'] ?>">

                <div class="mb-3">
                    <label for="category_name" class="form-label fw-bold">Category Name</label>
                    <input type="text" id="category_name" name="category_name" value="<?= $category_data[0]['category_name'] ?>" 
                        class="form-control border rounded" required>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    💾 Update
                </button>
            </form>
        </div>
    </div>
</div>
