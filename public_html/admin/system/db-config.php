<?php

include("php7_dependency/lib/mysql.php");
//die;

class DAO{

public function openConnection(){
 $conn = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die('Could not connect: ' . mysql_error());
 $db_connect = mysql_select_db(DB_NAME,$conn) or die('Could not select DB: ' . mysql_error());
 return $conn;
}
	
	public function closeConnection($conn){
		return mysqli_close($conn);
	}
	
	public function select($sql){
		$conn = $this->openConnection();
		$result = mysql_query($sql);
                        $final_array = array();
			$count=0;			
			while($row=mysql_fetch_array($result)){
				$tempArray = array();
				foreach($row as $key=>$value){
					if(!is_numeric($key)){
						$tempArray[$key] = $value;						
					}
				}
				$final_array[$count] = $tempArray;
				$count++;
			}
		
		//$this->closeConnection($conn);
		
		return $final_array;
	}
	
	public function insert($table, $data){
	    $sql="INSERT INTO `".$table."` ";
	    $columns = ''; 
	    $values = '';
	
	    foreach($data as $key=>$val){
	        $columns .= "`".$key."`, ";
			$values .= "'".$val."', ";
	    }
		$columns = substr($columns,0,strlen($columns)-2);
		$values = substr($values,0,strlen($values)-2);
	
	   	$sql .= "(".$columns.") VALUES (".$values.");";
	    
	    $conn = $this->openConnection();
		$result = mysql_query($sql);
		$inserted_id = mysql_insert_id();
		
		$finalResult = array();
		if($result){
			$finalResult['STATUS'] = 1;
			$finalResult['RESULT']['inserted_id'] = $inserted_id;
		}else{
			$finalResult['STATUS'] = 0;
			$finalResult['MESSAGE'] = mysql_error();
			$finalResult['RESULT']['user_id'] = $inserted_id;
		}
		$this->closeConnection($conn);
		return $finalResult;
	}
	
	public function insertquery($sql)
	{
		$conn = $this->openConnection();
		$result = mysql_query($sql);
		$inserted_id = mysql_insert_id();
		
		$finalResult = array();
		if($result){
			$finalResult['STATUS'] = 1;
			$finalResult['RESULT']['inserted_id'] = $inserted_id;
		}else{
			$finalResult['STATUS'] = 0;
			$finalResult['MESSAGE'] = mysql_error();
			$finalResult['RESULT']['user_id'] = $inserted_id;
		}
		$this->closeConnection($conn);
		return $finalResult;
		
	}
	public function update($table, $data, $where){
	    $sql="UPDATE `".$table."` SET ";
	    $set = '';
		$where_condition = ''; 
	    
	    foreach($data as $key=>$val){
	        $set .= "`".$key."`='".$val."', ";
	    }
		$set = substr($set,0,strlen($set)-2);
		
		foreach($where as $key=>$val){
	        $where_condition .= "`".$key."`='".$val."' AND ";
	    }
		$where_condition = substr($where_condition,0,strlen($where_condition)-5);
		
		$sql .= $set." WHERE ".$where_condition;		
	    
	    $conn = $this->openConnection();
		
		$result = mysql_query($sql);
		
		$finalResult = array();
		if($result){
			$finalResult['STATUS'] = 1;
			$finalResult['MESSAGE'] = "Updated successfully";
		}else{
			$finalResult['STATUS'] = 0;
			$finalResult['MESSAGE'] = mysql_error();
		}
		$this->closeConnection($conn);
		return $finalResult;
	}
	
	public function delete($table, $where){
	    $sql="DELETE FROM `".$table."` ";
	    $where_condition = ''; 
	    foreach($where as $key=>$val){
	        $where_condition .= "`".$key."`='".$val."' AND ";
	    }
		$where_condition = substr($where_condition,0,strlen($where_condition)-5);
		$sql .= " WHERE ".$where_condition;
	    
	    $conn = $this->openConnection();
		$result = mysql_query($sql);
		
		$finalResult = array();
		if($result){
			$finalResult['STATUS'] = 1;
			$finalResult['MESSAGE'] = "Deleted successfully";
		}else{
			$finalResult['STATUS'] = 0;
			$finalResult['MESSAGE'] = mysql_error();
		}
		$this->closeConnection($conn);
		return $finalResult;
	}
	
	public function query($sql){
		$conn = $this->openConnection();
		
		$result = mysql_query($sql);
		$final_result = array();
		if($result==1){
			$final_result['status'] = 1;
			
			$this->closeConnection($conn);
			return $final_result;
		}else{
			$final_result['status'] = 0;
			$final_result['error_message'] = mysql_error();
			
			$this->closeConnection($conn);
			return $final_result;
		}
	}
}
$DAO = new DAO(DB_HOST,DB_USER,DB_PASS,DB_NAME);


?>