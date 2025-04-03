<?php
// Extract order details
$order_id = $order_info['order_id'];


$cond = ["order_id"=>$order_id, "hotel_id"=>$_SESSION['hotel_id']];
		$data['order_info'] = $this->My_model->select_where("order_tbl",$cond)[0];

		$sql = "SELECT * FROM products 
        JOIN order_products ON products.product_id = order_products.product_id 
        WHERE order_products.order_id = '$order_id' 
        AND products.hotel_id = '{$_SESSION['hotel_id']}' 
        AND order_products.hotel_id = '{$_SESSION['hotel_id']}'";

		$data['order_products'] = $this->db->query($sql)->result_array();
        $total_amount2 = 0;
        $items = [];

foreach ($data['order_products'] as $product) {
    $items[] = "{$product['product_name']} ({$product['qty']} x {$product['product_price']})";
    $total_amount2 += $product['total'];
     if (strlen(implode(", ", $items)) > 80) {
        break;
    }
}

$total_amount= 0;
// Calculate total amount from order products
foreach ($order_products as $row) {
    $total_amount += $row['total'];
}

// Define UPI payment parameters
$merchant_upi = "kumardalvi2019@axl"; // Replace with your actual UPI ID
$payee_name = urlencode($hotel_details[0]['hotel_name']); // Encode special characters
// $transaction_note = urlencode("Payment for Order #$order_id");
// $transaction_note = urlencode("Payment for Order #$order_id - " . implode(", ", $items) . " | Total: $total_amount");
$transaction_note = urlencode("{$hotel_details[0]['hotel_name']} - Payment for Order #$order_id - " . implode(", ", $items) . " | Total: $total_amount");

// Generate Correct UPI Payment Link
$upi_link = "upi://pay?pa={$merchant_upi}&pn={$payee_name}&tn={$transaction_note}&am={$total_amount}&cu=INR";
?>

<!-- Include QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<div class="container text-center">
    <h2>Scan to Pay</h2>
    <p><strong>Order ID:</strong> <?= $order_id; ?></p>
    <p><strong>Amount:</strong> ₹<?= number_format($total_amount, 2); ?></p>

    <!-- QR Code -->
    <div class="d-flex justify-content-center align-items-center">
        <div id="qrcode"></div>
    </div>

    <p class="mt-3">Use any UPI app (Google Pay, PhonePe, Paytm) to scan and complete the payment.</p>

    <!-- Back Button -->
    <a href="<?= base_url('hotel/order_details/') . $order_id ?>" class="btn btn-primary mt-3">Go Back</a>
    <p class="mt-1 text-danger">Note: Ensure to manually verify the payment before proceeding.</p>
</div>

<script>
    // Clear previous QR codes
    document.getElementById('qrcode').innerHTML = "";

    // Generate new QR Code with the proper UPI link
    new QRCode(document.getElementById("qrcode"), "<?= $upi_link; ?>");
</script>
