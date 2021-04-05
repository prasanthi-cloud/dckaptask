<?php
include('Database.php');
class Product{
	public function __construct(){
		$this->db = new Database();
		$this->db->connect();
	}

	public function getProducts(){
		$this->res= $this->db->select('product');
		return $this->res; 
	}
	public function getProductsByCatId($category_id){
		$this->res= $this->db->select('product','*','category_id='.$category_id);
		return $this->res; 
	}
	public function getProductByProdId($prod_id){
		$this->res= $this->db->select('product','*','product_id='.$prod_id);
		return $this->res; 
	}
	public function getCartProducts($cond){
		$this->res = $this->db->select('product','*',$cond);
		return $this->res;
	}
}


?>