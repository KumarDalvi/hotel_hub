<?php
class Login extends CI_Controller
{
	function index()
	{
		$this->load->view("login_form");
	}
	function process_login()
	{
		print_r($_POST);
		if (isset($_POST['email']) && isset($_POST['password'])) 
		{
			$cond['hotel_email'] = $_POST['email'];
			$cond['hotel_password'] = $_POST['password'];
			$match = $this->My_model->select_where("hotel",$cond);
			

			if(isset($match[0]['hotel_id']))
			{
				$_SESSION['hotel_id'] = $match[0]['hotel_id'];
				$_SESSION['hotel_name'] = $match[0]['hotel_name'];
				$_SESSION['hotel_image'] = $match[0]['hotel_image'];
				redirect(base_url("hotel"));
			}
			else
			{
				 $this->session->set_flashdata('error', 'Login failed! Invalid email or password.');
            redirect(base_url("login")); // Reload the login page
			}
		}
		else
		{
			 $this->session->set_flashdata('error', 'Invalid request. Please try again.');
        redirect(base_url("login")); // Reload the login page
		}

	}
}
?>