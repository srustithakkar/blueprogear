<?php

class ethinicity 
{

    function __construct()
    {
    
        $this->table_name = 'ethinicity';
    }
	
	function ethinicitylist()
	{
		global $DAO;
		$sql = "SELECT * FROM `ethinicity` where is_delete=0 order by name";
		$result = $DAO->select($sql);
		return $result;	
	}
	
	function add($name)
	{
		global $DAO;
		$now = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `ethinicity` (`name`,`created`) VALUES ('".$name."','".$now."')";
		$q = $DAO->insertquery($sql);
		if($q['RESULT']['inserted_id'])
		{
			return $q['RESULT']['inserted_id'];
		}
		else
		{
			return false;
		}		
	}
	
	function edit($data,$id)
	{
		global $DAO;
		$where = array('id'=>$id);
		$q = $DAO->update('ethinicity',$data,$where);
		return true;
	}
	
	
	function delete()
	{
		global $DAO;
		
		$id = addslashes(trim($_REQUEST['delete_ethinicity']));
		
		$ethinicitydata = $this->ethinicitydetailbyid($id);
		$name = $ethinicitydata[0]['name'];
		$logmsg = "Deleted ethinicity '$name'";
		activitylog($_SESSION['user']['user_id'],$logmsg);
		
		
		
		$sql = "UPDATE `ethinicity` SET `is_delete` = 1 WHERE `id` = $id";
		$q = $DAO->query($sql);
		
		
		
		
		$sql = "SELECT user_id FROM `user` WHERE `ethinicity`='".$id."' AND user_type =3";
	    $result = $DAO->select($sql);
		foreach($result as $value) 
		{
			$data = array('ethinicity'=>0);
			$where = array('user_id'=>$value['user_id']);
			$q = $DAO->update('user',$data,$where);
		}
		return true;
	}
	
	function deactivate()
	{
		global $DAO;
		$id = addslashes(trim($_REQUEST['deactive_category']));
		
		
		$categorydata = $this->categorydetailbyid($id);
		$name = $categorydata[0]['name'];
		$logmsg = "Deactivate category '$name'";
		activitylog($_SESSION['user']['user_id'],$logmsg);
		
		
		
		$sql = "UPDATE `category` SET `status` = 0 WHERE `id` = $id";
		$q = $DAO->query($sql);
		
		$sql = "SELECT venue_id,manager_id FROM `venue` WHERE `category_id`='".$id."'";
	    $result = $DAO->select($sql);
		foreach($result as $value) 
		{
			$data = array('status'=>2);
			$where = array('venue_id'=>$value['venue_id']);
			$q = $DAO->update('venue',$data,$where);
		
			$data = array('status'=>0);
			$where = array('venue_id'=>$value['venue_id']);
			$q = $DAO->update('offers',$data,$where);
		}
		
		return true;
	}
	
	function activate()
	{
		global $DAO;
		$id = addslashes(trim($_REQUEST['active_category']));
		
		
		
		$sql = "UPDATE `category` SET `status` = 1 WHERE `id` = $id";
		$q = $DAO->query($sql);
		
		$categorydata = $this->categorydetailbyid($id);
		$name = $categorydata[0]['name'];
		$logmsg = "Activate category '$name'";
		activitylog($_SESSION['user']['user_id'],$logmsg);
		
		return true;
	}
	
	function ethinicitydetailbyid($id)
	{
		global $DAO;
	    $sql = "SELECT * FROM `ethinicity` WHERE `id`=$id";
	    $result = $DAO->select($sql);
		return $result;
	}
	
}

?>
