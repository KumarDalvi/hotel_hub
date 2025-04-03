
<?php
$default_path = base_url()."assets/img/icons/icon-48x48.png";   
$hotel_image_path = base_url()."uploads/".$_SESSION['hotel_image']; 


$hotel_id = $this->session->userdata('hotel_id');
$hotel_data = $this->My_model->select_where("hotel", array("hotel_id" => $hotel_id));

if (!empty($hotel_data)) {
    $hotel = $hotel_data[0];
} else {
    echo "<div class='alert alert-danger text-center'>Hotel data not found!</div>";
    return;
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0">Update Hotel Profile</h2>
                </div>
                <div class="card-body">
                    
                    <form action="<?= base_url('hotel/update_profile'); ?>" method="post" enctype="multipart/form-data">
                        
                        <!-- Hotel Name -->
                        <div class="mb-3">
                            <label class="form-label">Hotel Name</label>
                            <input type="text" name="hotel_name" class="form-control" 
                                   value="<?= htmlspecialchars($hotel['hotel_name']); ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="hotel_email" class="form-control" 
                                   value="<?= htmlspecialchars($hotel['hotel_email']); ?>" required>
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="text" name="hotel_mobile" class="form-control" 
                                   value="<?= htmlspecialchars($hotel['hotel_mobile']); ?>" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="hotel_address" class="form-control" required><?= htmlspecialchars($hotel['hotel_address']); ?></textarea>
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="hotel_rating" class="form-select" required>
                                <option value="1" <?= $hotel['hotel_rating'] == 1 ? 'selected' : ''; ?>>1 ⭐</option>
                                <option value="2" <?= $hotel['hotel_rating'] == 2 ? 'selected' : ''; ?>>2 ⭐</option>
                                <option value="3" <?= $hotel['hotel_rating'] == 3 ? 'selected' : ''; ?>>3 ⭐</option>
                                <option value="4" <?= $hotel['hotel_rating'] == 4 ? 'selected' : ''; ?>>4 ⭐</option>
                                <option value="5" <?= $hotel['hotel_rating'] == 5 ? 'selected' : ''; ?>>5 ⭐</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="hotel_description" class="form-control" required><?= htmlspecialchars($hotel['hotel_description']); ?></textarea>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-3">
                            <label class="form-label">Facilities Available</label>
                            <textarea name="hotel_facilities" class="form-control" required><?= htmlspecialchars($hotel['hotel_facilities']); ?></textarea>
                        </div>

                        <!-- Website -->
                        <div class="mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" name="hotel_website" class="form-control" 
                                   value="<?= htmlspecialchars($hotel['hotel_website']); ?>" required>
                        </div>

                        <!-- Profile Image -->
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="hotel_image" class="form-control">
                            <?php if (!empty($hotel['hotel_image'])): ?>
                                <div class="mt-2">
                                    <img src="<?= isset($_SESSION['hotel_image']) && !empty($_SESSION['hotel_image']) ? $hotel_image_path : $default_path ?>" 
                                         alt="Current Image" class="img-fluid rounded" 
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
