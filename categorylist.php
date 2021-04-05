<?php
include('Database.php');
class Category{
	public function __construct(){
		$this->db = new Database();
		$this->db->connect();
	}

	public function getCategories(){
		$this->res= $this->db->select('categories');
		return $this->res; 
	}
}
?>
