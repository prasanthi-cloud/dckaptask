<?php
include('Database.php');
class Orders{
	public function __construct(){
		$this->db = new Database();
		$this->db->connect();
	}
	public function insertOrder($table='orders',$values,$rows){
		$this->res=$this->db->insert($table,$values,$rows);
		
		if($this->res){
			return true;
		}
		else{
			return false;
		}
	}
	
	
}
?>