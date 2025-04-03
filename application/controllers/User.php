<?php
class User extends CI_Controller

{

	public function index()
	{
		
		$_SESSION['table_id'] = $_GET['table_no'];
		$_SESSION['hotel_id'] = $_GET['hotel_id'];
		$data['cats'] = $this->My_model->get_cats();
		$data['products'] = $this->My_model->get_products();
        $data['hotel_details'] = $this->My_model->select_where("hotel",["hotel_id"=>$_SESSION['hotel_id']]);
		$this->load->view("user/products",$data);

	}
	public function add_product_in_session()
	{
		$_SESSION['cart'][$_GET['product_id']] = $_GET['qty'];
		if ($_GET['qty'] == 0)
		{
			unset($_SESSION['cart'][$_GET['product_id']]);
		}
		echo json_encode(["status"=>"success"]);
	}
public function send_to_kitchen()

{
    
date_default_timezone_set('Asia/Kolkata');
    if (!isset($_SESSION['table_id']) || empty($_SESSION['table_id'])) {
        show_error("Table ID is missing.");
        return;
    }

    $hotel_table_id = $_SESSION['table_id'];
    $hotel_id = $_SESSION['hotel_id'];

    // Check if an active order already exists
    $query = "SELECT order_id FROM order_tbl 
              WHERE hotel_table_id = $hotel_table_id 
              AND hotel_id = $hotel_id 
              AND order_status = 'active' 
              ORDER BY order_id DESC LIMIT 1";

    $data = $this->db->query($query)->row_array();
    $order_id = $data['order_id'] ?? null;

    // If no active order exists, insert a new one
    if (!$order_id) {
        $order = [
            "order_date" => date('Y-m-d'),
            "hotel_table_id" => $hotel_table_id,
            "order_time" => date('H:i'),
            "order_status" => "active",
            "hotel_id" => $hotel_id
        ];
        $order_id = $this->My_model->insert("order_tbl", $order);
    }

    // Ensure the cart is not empty before proceeding
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        show_error("Cart is empty.");
        return;
    }

    // Process the cart items
    foreach ($_SESSION['cart'] as $product_id => $qty) {
        // Fetch product details
        $cond = ["product_id" => $product_id, "hotel_id" => $hotel_id];
        $product = $this->My_model->select_where("products", $cond);

        if (!empty($product)) {
            $product_price = $product[0]['product_price'] ?? 0;
            $total = $product_price * $qty;

            $order_product = [
                "order_id" => $order_id,
                "product_id" => $product_id,
                "qty" => $qty,
                "product_price" => $product_price,
                "total" => $total,
                "hotel_id" => $hotel_id
            ];

            // Insert order details correctly
            $this->My_model->insert("order_products", $order_product);
        } else {
            log_message('error', "Missing product details for product_id: $product_id, hotel_id: $hotel_id");
        }
    }

    // Redirect after processing
    redirect(base_url('user/thank_you'));
}


 public function cart_data() {
        $this->load->view('user/cart_data'); // Load a view with cart contents
    }


	public function thank_you()
	{
		$_SESSION['cart'] = [];
		$this->load->view("user/thank_you");
	}

}
?>

