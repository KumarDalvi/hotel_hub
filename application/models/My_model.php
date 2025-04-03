<?php

class My_model extends CI_Model
{
	function insert($tname, $data)
	{
		$this->db->insert($tname, $data);
		return $this->db->insert_id();
	}
	function insert_where($tname, $cond, $data)
	{

	}
	function select($tname)
	{
		return $this->db->get($tname)->result_array();
	}
	function select_where($tname, $cond)
	{
		return $this->db->where($cond)->get($tname)->result_array();
	}


	function get_cats()
	{
		$cond = ["hotel_id"=>$_SESSION['hotel_id']];
		return $this->My_model->select_where("category",$cond);
	}
	// function get_cat_for_user($id)
	// {
	// 	$cond = ["hotel_id"=>$_SESSION['hotel_id']];

	// }

	public function get_products()
{
    $sql = "SELECT products.*, category.category_name 
        FROM products 
        JOIN category ON products.category_id = category.category_id 
        WHERE products.hotel_id = '" . $_SESSION['hotel_id'] . "' 
        AND category.hotel_id = '" . $_SESSION['hotel_id'] . "'";

    return $this->db->query($sql)->result_array();
}

	function search_products($name)
	{
		return $this->db->query("
    		SELECT * FROM products 
    		JOIN category ON products.category_id = category.category_id 
    		WHERE (product_name LIKE '%$name%' OR category_name LIKE '%$name%') 
    		AND products.hotel_id = '{$_SESSION['hotel_id']}'
    		AND category.hotel_id = '{$_SESSION['hotel_id']}'
		")->result_array();

	}
	public function update($table, $where, $data )
{
    $this->db->where($where);
    return $this->db->update($table, $data);
    

}

function delete($tname, $cond)
	{
		return $this->db->where($cond)->delete($tname);
	}
	
}

?>
