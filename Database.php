<?php
class Database
{
	private $db_host = 'localhost'; 
	private $db_user = 'root'; 
	private $db_pass = ''; 
	private $db_name = 'shoppingcart_db';
	private $result = array();
	public $con='';
    public function connect()   {
		if(!$this->con)
        {
            
			$myconn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			if ($myconn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
            else
            {
				$this->con = $myconn; 
				return $this->con;    
            }
        } else
        {//echo "ada";
            return $this->con; 
        }
	}
    public function disconnect(){
		if($this->con)
		{
			$conn->close();	
			$this->con ='';
			return $this->con;			
		}
	}
	 
 
	private function tableExists($table){
        $tablesInDb = $this->con->query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb)
        {
            if($tablesInDb->num_rows==1)
            {
                return true; 
            }
            else
            { 
                return false; 
            }
        }
    }
    public function select($table, $rows = '*', $where = null,$values=null, $order = null){
		 $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
		//$conn = $this->connect();
		//$this->tableExists($table);
		//echo $q;
       if($this->tableExists($table))
       {
		  
		  $result =$this->con->query($q);
		 $this->numResults = $result->num_rows;
        if($result)
        {
            //echo $this->numResults = $result->num_rows;
            for($i = 0; $i < $this->numResults; $i++)
            {
                $r =$result->fetch_assoc();
                $key = array_keys($r); 
                for($x 	= 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so 	only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
                        if($this->numResults > 1)
                            $this->result_set[$i][$key[$x]] = $r[$key[$x]];
                        else if($this->numResults < 1)
                            $this->result_set = null; 
                        else
                            $this->result_set[$key[$x]] = $r[$key[$x]]; 
                    }
                }
            }            
            return $this->result_set; 
        }
        else
        {
            return false; 
        }
        }
	else
      return false; 
	}
    public function insert($table,$values,$rows = null)
    {
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')'; 
            }
 
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
           echo  $insert .= ' VALUES ('.$values.')';
            $ins = $this->con->query($insert);            
            if($ins)
            {
                return true; 
            }
            else
            {
                return false; 
            }
        }
    }
	
   // public function delete()        {   }
    //public function update()    {   }
}