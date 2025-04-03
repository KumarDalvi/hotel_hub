<style>
.order-confirmation {
    text-align: center;
    margin: 50px auto;
    max-width: 600px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    font-family: "Poppins", sans-serif;
}

.hotel-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

h1 {
    font-size: 28px;
    color: #222;
    font-weight: bold;
    margin-top: 15px;
}

p {
    font-size: 18px;
    color: #555;
}

span {
    color: #007bff;
    font-weight: bold;
}

.hotel-info {
    text-align: left;
    margin-top: 20px;
    padding: 15px;
    border-radius: 8px;
    background: #f8f9fa;
}

.hotel-info h2 {
    font-size: 22px;
    color: #007bff;
}

.hotel-info p {
    margin: 10px 0;
    font-size: 16px;
}

.hotel-info a {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.hotel-info a:hover {
    text-decoration: underline;
}

.home-btn {
    display: inline-flex;
    align-items: center;
    background: #007bff;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    transition: 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
}

.home-btn:hover {
    background: #0056b3;
    transform: scale(1.05);
}

.home-btn svg {
    margin-right: 8px;
}

.htl_name{
    color: #007bff;
}

</style>
<?php
    $data['hotel_details'] = $this->My_model->select_where("hotel",["hotel_id"=>$_SESSION['hotel_id']]);
    
?>
<div class="order-confirmation">
    <img src="<?= base_url('uploads/') . $data['hotel_details'][0]['hotel_image'] ?>" alt="Hotel Image" class="hotel-image">
    
    <h1>Thank You for Your Order!</h1>
    <p>Your order will be delivered within <span>15 to 20 minutes</span>.</p>

    <div class="hotel-info">
        <p class="text-center text-secondary fw-semibold">  
    Sit back & relax—  
    <strong class="text-danger htl_name"><?= htmlspecialchars($data['hotel_details'][0]['hotel_name']) ?></strong>  
    is preparing your meal with care!  
</p>

        <p><strong>Address:</strong> <?= $data['hotel_details'][0]['hotel_address'] ?></p>
        <p><strong>Contact:</strong> <a href="tel:<?= $data['hotel_details'][0]['hotel_mobile'] ?>"><?= $data['hotel_details'][0]['hotel_mobile'] ?></a></p>
        <p><strong>Website:</strong> <a href="<?= $data['hotel_details'][0]['hotel_website'] ?>" target="_blank">Visit Us</a></p>
    </div>

    <a href="<?= base_url() ?>user/index?table_no=<?= $_SESSION['table_id'] ?>&hotel_id=<?= $_SESSION['hotel_id'] ?>" class="home-btn">
        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12l9-9 9 9"></path>
            <path d="M9 21V9h6v12"></path>
        </svg>
        Back to Home
    </a>
</div>
