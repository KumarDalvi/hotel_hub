<?php
$default_path = base_url()."assets/img/icons/icon-48x48.png";   
$hotel_image_path = base_url()."uploads/".$_SESSION['hotel_image']; 

$hotel_id = $this->session->userdata('hotel_id');

$hotel_data = $this->My_model->select_where("hotel", array("hotel_id" => $hotel_id));

if (!empty($hotel_data)) {
    $hotel = $hotel_data[0]; // Fetch first result
} else {
    echo "<div class='alert alert-danger text-center'>Hotel data not found!</div>";
    return;
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Hotel Profile</h2>
                </div>
                <div class="card-body">
                    
                    <!-- Hotel Image -->
                    <div class="text-center mb-3">
                        <img src="<?= isset($_SESSION['hotel_image']) && !empty($_SESSION['hotel_image']) ? $hotel_image_path : $default_path ?>" 
                             alt="Hotel Image" class="img-fluid rounded-circle" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Hotel Name:</th>
                                <td><?= htmlspecialchars($hotel['hotel_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= htmlspecialchars($hotel['hotel_email']); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile:</th>
                                <td><?= htmlspecialchars($hotel['hotel_mobile']); ?></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><?= htmlspecialchars($hotel['hotel_address']); ?></td>
                            </tr>
                            <tr>
                                <th>Rating:</th>
                                <td>
                                    <?= htmlspecialchars($hotel['hotel_rating']); ?> ⭐
                                </td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td><?= nl2br(htmlspecialchars($hotel['hotel_description'])); ?></td>
                            </tr>
                            <tr>
                                <th>Facilities:</th>
                                <td><?= nl2br(htmlspecialchars($hotel['hotel_facilities'])); ?></td>
                            </tr>
                            <tr>
                                <th>Website:</th>
                                <td>
                                    <a href="<?= htmlspecialchars($hotel['hotel_website']); ?>" 
                                       target="_blank" class="text-decoration-none">
                                       <?= htmlspecialchars($hotel['hotel_website']); ?>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer text-center">
                    <a href="<?= base_url('hotel/edit_profile'); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
