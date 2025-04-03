<?php

class Hotel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['hotel_id'])) {
			redirect(base_url("login"));
		}
	}
	protected function navbar()
	{
		$this->load->view("hotel/navbar");
	}
	protected function footer()
	{
		$this->load->view("hotel/footer");
	}
	
	public function index()
{
	$this->navbar();
	$cond = ['hotel_id' => $_SESSION['hotel_id']];
	$data['tables'] = $this->My_model->select_where("hotel_table", $cond);

	$dates = [];
	$amounts = [];
	for ($i=0; $i < 7; $i++) 
	{ 
		$d = date('Y-m-d',strtotime("-$i day"));
		$dates[] = $d;

		$sql = "SELECT 
            SUM((SELECT SUM(total) FROM order_products 
                 WHERE order_tbl.order_id = order_products.order_id)) as ttl 
        FROM order_tbl 
        WHERE order_date = '$d' 
        AND order_tbl.order_status ='complete'
        AND hotel_id = '" . $_SESSION['hotel_id'] . "'";


		$day_total = $this->db->query($sql)->result_array();
		
		$amounts[] = (int)$day_total[0]['ttl'];
	}
	$data['x_axis'] = $dates;
	$data['y_axis'] = $amounts;

	$this->load->view("hotel/index", $data);
	$this->footer();
}

	public function manage_table()
	{
		$this->navbar();
		$cond = ['hotel_id' => $_SESSION['hotel_id']];
		$data['tables'] = $this->My_model->select_where("hotel_table",$cond);
		$this->load->view("hotel/manage_table", $data);
		$this->footer();
	}
    public function edit_table()
    {   
        $this->navbar();
      $data['tbl_data'] = $this->My_model->select_where("hotel_table",["hotel_table_id"=>$_GET['hotel_table_id']]);

      $this->load->view("hotel/edit_table",$data);
    $this->footer();
    }
    public function update_table()
	{
          
		$cond = ["hotel_id" => $_SESSION['hotel_id'], "hotel_table_id" => $_POST['hotel_table_id'] ];
		$data = ["table_no" => $_POST['table_no'] ];

		$this->My_model->update("hotel_table", $cond, $data);
		redirect(base_url("hotel/manage_table"));
	} 
     public function delete_table()
    {
        print_r($_GET);
        $cond = ['hotel_table_id'=>$_GET['hotel_table_id'], 'hotel_id'=>$_SESSION['hotel_id']];
		$this->My_model->delete("hotel_table",$cond);
        
		redirect(base_url("hotel/manage_table"));
    }
	public function save_table(){

		$_POST['hotel_id'] = $_SESSION['hotel_id'];
		$this->My_model->insert("hotel_table",$_POST);
		redirect(base_url("hotel/manage_table"));
	}

	public function manage_category()
	{
		$this->navbar();

		$data['cats']= $this->My_model->get_cats();
		$this->load->view("hotel/manage_category",$data);

		$this->footer();
	}

	public function edit_category()
	{	
		$this->navbar();
		$cond = ['category_id' => $_GET['category_id'],'hotel_id'=>$_SESSION['hotel_id']];
		$data['category_data'] = $this->My_model->select_where("category",$cond);
		$this->load->view("hotel/edit_category",$data);
		$this->footer();
	}
	public function update_category()
	{
		
		$cond = ["hotel_id" => $_SESSION['hotel_id'], "category_id" => $_POST['category_id'] ];
		$data = ["category_name" => $_POST['category_name'] ];

		$this->My_model->update("category", $cond, $data);
		redirect(base_url("hotel/manage_category"));
	} 
	public function save_category(){
		

		$_POST['hotel_id'] = $_SESSION['hotel_id'];
		$this->db->insert("category", $_POST);
		redirect(base_url("hotel/manage_category"));
	}

	public function delete_category()
	{
		$cond = ['category_id'=>$_GET['category_id'], 'hotel_id'=>$_SESSION['hotel_id']];
		$this->My_model->delete("category",$_GET);
        
		redirect(base_url("hotel/manage_category"));

	}
   

	public function add_product()
	{
		$this->navbar();
		$data['cats']= $this->My_model->get_cats();
		$this->load->view("hotel/add_product",$data);
		$this->footer();
	}
	public function edit_product()
	{
		$this->navbar();
		$cond = ['product_id'=>$_GET['product_id'], 'hotel_id'=>$_SESSION['hotel_id']];
		
		$data['product']= $this->My_model->select_where("products",$cond);
		$data['categories'] = $this->My_model->select_where("category",$_SESSION['hotel_id']);
		$this->load->view("hotel/edit_product",$data);		
		$this->footer();
	}
	
public function update_product()
{
	
    $hotel_id = $this->session->userdata('hotel_id');
    if ($hotel_id === "" || $hotel_id === null) {
        echo "Error: Hotel ID not found in session.";
        return;
    }

    $postData = $this->input->post();
   
    // Get form data
    $postData = $this->input->post();
    $product_id = $postData['product_id'];
    $category_id = $postData['category_id'];
    $product_name = $postData['product_name'];
    $product_price = $postData['product_price'];
    $old_product_image = $postData['old_product_image']; // Existing image

    $product_image = ""; // Variable for new image

    // Check if a new image is uploaded
    if (!empty($_FILES['product_image']['name'])) {
        $config['upload_path']   = './uploads/'; // Upload folder
        $config['allowed_types'] = 'jpg|jpeg|png|webp'; // Allowed file types
        $config['file_name']     = time() . '_' . $_FILES['product_image']['name']; // Unique filename

        // Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // Try uploading the new image
        if ($this->upload->do_upload('product_image')) {
            $uploadData = $this->upload->data();
            $product_image = $uploadData['file_name']; // Get the new image filename

            // Optional: Delete old image if needed
            if (!empty($old_product_image) && file_exists('./uploads/' . $old_product_image)) {
                unlink('./uploads/' . $old_product_image);
            }
        } else {
            echo "Image upload failed: " . $this->upload->display_errors();
            return;
        }
    }

    // Prepare data for updating the product
    $update_data = [
        'category_id'   => $category_id,
        'product_name'  => $product_name,
        'product_price' => $product_price,
    ];

    // If a new image is uploaded, update the image field; otherwise, keep the old one
    if (!empty($product_image)) {
        $update_data['product_image'] = $product_image;
    } else {
        $update_data['product_image'] = $old_product_image; // Keep old image if no new one
    }

    // Perform update in database with additional hotel_id check
    $cond = ['product_id' => $product_id, 'hotel_id' => $hotel_id];
    $update = $this->My_model->update('products', $cond, $update_data);

    

	redirect(base_url("hotel/product_list"));

}




	public function delete_product()
	{
		$cond = ['product_id'=>$_GET['product_id'],'hotel_id'=>$_SESSION['hotel_id']];
		$this->My_model->delete("products",$_GET);
		redirect(base_url("hotel/product_list"));
	}
	public function save_product(){
		
		$_POST['hotel_id'] = $_SESSION['hotel_id'];
		
		$_POST['product_image'] = $image_name = time().$_FILES['product_image']['name'];
		move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/$image_name");
		
		$this->My_model->insert("products",$_POST);

		redirect("hotel/add_product");
	}
	
	public function product_list()
	{
		$this->navbar();
		if (isset($_GET['search']))
		{
		$data['products'] = $this->My_model->search_products($_GET['search']);
		}
		else
		{
		$data['products'] = $this->My_model->get_products();
		}
		$this->load->view("hotel/product_list",$data);
		$this->footer();
	}
	public function order_details($order_id)
	{
        $data['hotel_details'] = $this->My_model->select_where("hotel",["hotel_id"=>$_SESSION['hotel_id']]);
		$cond = ["order_id"=>$order_id, "hotel_id"=>$_SESSION['hotel_id']];
		$data['order_info'] = $this->My_model->select_where("order_tbl",$cond)[0];

		$sql = "SELECT * FROM products 
        JOIN order_products ON products.product_id = order_products.product_id 
        WHERE order_products.order_id = '$order_id' 
        AND products.hotel_id = '{$_SESSION['hotel_id']}' 
        AND order_products.hotel_id = '{$_SESSION['hotel_id']}'";

		$data['order_products'] = $this->db->query($sql)->result_array();
        $data['hotel_details'] = $this->My_model->select_where("hotel",["hotel_id"=>$_SESSION['hotel_id']]);
		$this->navbar();
		$this->load->view("hotel/order_details",$data);
		$this->footer();
	}
	function payment_qr($order_id)
	{

		$cond = ["order_id"=>$order_id, "hotel_id"=>$_SESSION['hotel_id']];
		$data['order_info'] = $this->My_model->select_where("order_tbl",$cond)[0];
        $data['hotel_details'] = $this->My_model->select_where("hotel",["hotel_id"=>$_SESSION['hotel_id']]);

		$sql = "SELECT * FROM products 
        JOIN order_products ON products.product_id = order_products.product_id 
        WHERE order_products.order_id = '$order_id' 
        AND products.hotel_id = '{$_SESSION['hotel_id']}' 
        AND order_products.hotel_id = '{$_SESSION['hotel_id']}'";

		$data['order_products'] = $this->db->query($sql)->result_array();

		
		$ttl=0;
		foreach ($data['order_products'] as $key => $row) {

			$ttl += $row['total'];
			
		}
		$this->navbar();
		$this->load->view("hotel/payment_qr", $data);
		$this->footer();


	}
	function close_order($order_id)
	{
		$cond = ["order_id"=>$order_id, "hotel_id"=>$_SESSION['hotel_id']];
			
		$data = ["order_status"=>"complete"];
		$this->My_model->update("order_tbl",$cond,$data);
		redirect(base_url()."hotel/order_details/$order_id");
	}

    function cancel_order($order_id)
    {
        $cond = ["order_id"=>$order_id, "hotel_id"=>$_SESSION['hotel_id']];
			
		$data = ["order_status"=>"cancel"];
		$this->My_model->update("order_tbl",$cond,$data);
		redirect(base_url()."hotel/order_details/$order_id");
    }
	function log_out()
	{
		unset($_SESSION['hotel_id']);
		redirect(base_url());
	}

	function change_password()
	{
		$this->navbar();
		$this->load->view("hotel/change_password");
		$this->footer();
	}
	function update_password()
	{
		$cond = ["hotel_id"=>$_SESSION['hotel_id']];
		$hotel_data = $this->My_model->select_where("hotel",$cond);

		if ($_POST['old_password'] == $hotel_data[0]['hotel_password'])
			{
			if ($_POST['new_password'] == $_POST['confirm_password'] )
			{
			$data = ["hotel_password"=>$hotel_password = $_POST['new_password'] ];
			$this->My_model->update("hotel",$cond,$data);	
			unset($_SESSION['hotel_id']);
			redirect(base_url("login"));
			}
			else{
				echo "password not matched";
			}
		}
		else
		{
			echo "<br>not matched";
		}
	}
	function profile()
	{
		$this->navbar();
		$this->load->view("hotel/profile");
		$this->footer();
	}
	function edit_profile()
	{
		$this->navbar();
		$this->load->view("hotel/edit_profile");
		$this->footer();
	}
public function update_profile()
{
    session_start(); // Start the session

    // Check if hotel_id is set in session
    if (!isset($_SESSION['hotel_id'])) {
        echo "Session expired. Please log in again.";
        exit();
    }

    $hotel_id = $_SESSION['hotel_id']; // Get hotel_id from session

    // Capture POST data
    $data = array(
        "hotel_name"       => $this->input->post("hotel_name"),
        "hotel_email"      => $this->input->post("hotel_email"),
        "hotel_mobile"     => $this->input->post("hotel_mobile"),
        "hotel_address"    => $this->input->post("hotel_address"),
        "hotel_rating"     => $this->input->post("hotel_rating"),
        "hotel_description"=> $this->input->post("hotel_description"),
        "hotel_facilities" => $this->input->post("hotel_facilities"),
        "hotel_website"    => $this->input->post("hotel_website"),
    );

    // Handle Image Upload
    if (!empty($_FILES['hotel_image']['name'])) {
        $config['upload_path']   = './uploads/'; // Ensure 'uploads' folder exists
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        // $config['max_size']      = 2048; // 2MB max
        $config['file_name']     = "hotel_" . $hotel_id . "_" . time(); // Unique filename

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('hotel_image')) {
            $upload_data = $this->upload->data();
            $data['hotel_image'] = $upload_data['file_name']; // Store only file name in DB
        } else {
            echo "Image upload failed: " . $this->upload->display_errors();
            exit();
        }
    }

    // Perform update
    $this->db->where("hotel_id", $hotel_id);
    $updated = $this->db->update("hotel", $data);

    redirect(base_url("hotel/profile"));
    
}

// function order_records()
// {
	

// 	$cond = ["order_status !="=>"active", "hotel_id"=>$_SESSION['hotel_id']];
//     // $cond = ["hotel_id"=>$_SESSION['hotel_id']];
// 	$data['order_info'] = $this->My_model->select_where("order_tbl",$cond);
// 	$this->navbar();
// 	$this->load->view("hotel/order_records",$data);
// 	$this->footer();
// }

function order_records()
{
    $this->load->library('session'); // Load session

    // Ensure hotel_id is dynamically set
    $hotel_id = $this->session->userdata('hotel_id') ?? 0;

    // Default condition (fetch orders except "active" for the current hotel)
    $cond = ["order_status !=" => "active", "hotel_id" => $hotel_id];

    // Initialize search conditions
    if (!empty($this->input->get('search_order_id'))) {
        $cond['order_id'] = $this->input->get('search_order_id');
    }
    if (!empty($this->input->get('search_date'))) {
        $cond['order_date'] = $this->input->get('search_date');
    }
    if (!empty($this->input->get('search_table'))) {
        $cond['hotel_table_id'] = $this->input->get('search_table');
    }
    if (!empty($this->input->get('search_status'))) {
        $cond['order_status'] = $this->input->get('search_status');
    }

    // Fetch filtered orders
    $data['order_info'] = $this->My_model->select_where("order_tbl", $cond);

    $this->navbar();
    $this->load->view("hotel/order_records", $data);
    $this->footer();
}
// Ensure these namespaces are at the top of your controller
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

public function export_order_records()
{
    // Load session
    $this->load->library('session');

    // Ensure hotel_id is dynamically set
    $hotel_id = $this->session->userdata('hotel_id') ?? 0;

    // Default condition (fetch orders except "active" for the current hotel)
    $cond = ["order_status !=" => "active", "hotel_id" => $hotel_id];

    // Apply filters based on search input
    if (!empty($this->input->get('search_order_id'))) {
        $cond['order_id'] = $this->input->get('search_order_id');
    }
    if (!empty($this->input->get('search_date'))) {
        $cond['order_date'] = $this->input->get('search_date');
    }
    if (!empty($this->input->get('search_table'))) {
        $cond['hotel_table_id'] = $this->input->get('search_table');
    }
    if (!empty($this->input->get('search_status'))) {
        $cond['order_status'] = $this->input->get('search_status');
    }

    // Fetch orders
    $order_info = $this->My_model->select_where("order_tbl", $cond);

    // Create a new spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column headers
    $sheet->setCellValue('A1', 'Order ID');
    $sheet->setCellValue('B1', 'Table No');
    $sheet->setCellValue('C1', 'Date');
    $sheet->setCellValue('D1', 'Time');
    $sheet->setCellValue('E1', 'Status');
    $sheet->setCellValue('F1', 'Grand Total');

    // Fill data
    $rowNum = 2;
    foreach ($order_info as $row) {
        $order_id = $row['order_id'];
        $hotel_id = $row['hotel_id'];

        // Get table number
        $tbl_sql = "SELECT table_no FROM hotel_table WHERE hotel_table_id = " . $row['hotel_table_id'];
        $query = $this->db->query($tbl_sql);
        $table = $query->row_array();
        $table_no = isset($table['table_no']) ? $table['table_no'] : "N/A";

        // Get order total
        $grand_total = 0;
        $order_status = strtolower($row['order_status']); // Normalize status

        $sql = "SELECT * FROM products, order_products 
                WHERE order_products.order_id = {$order_id} 
                AND products.product_id = order_products.product_id
                AND order_products.hotel_id = '{$hotel_id}' 
                AND products.hotel_id = '{$hotel_id}'"; 
        $order_products = $this->db->query($sql)->result_array();

        foreach ($order_products as $product) {
            $item_total = $product['qty'] * $product['product_price'];
            $grand_total += $item_total;
        }

        // Fill row with data
        $sheet->setCellValue('A' . $rowNum, $row['order_id']);
        $sheet->setCellValue('B' . $rowNum, $table_no);
        $sheet->setCellValue('C' . $rowNum, date("d M Y", strtotime($row['order_date'])));
        $sheet->setCellValue('D' . $rowNum, date("h:i A", strtotime($row['order_time'])));
        $sheet->setCellValue('E' . $rowNum, ucfirst($order_status));
        $sheet->setCellValue('F' . $rowNum, '₹ ' . number_format($grand_total, 2));

        $rowNum++;
    }

    // Set headers for file download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="order_records.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}









}
?>
