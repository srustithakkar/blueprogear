<?php
    include('system/config.php');
    
    if(isset($_REQUEST['token']) && $_REQUEST['token']=="invalid"){
        session_destroy();
        header("Location: login.php?msg=7");
        die();
    }else{
    	
		global $DAO;
		$user_id = $_SESSION['user']['user_id'];
		$sql = "SELECT * FROM `timelog_manage` where logout = '0000-00-00 00:00:00' AND user_id='$user_id' order by id desc limit 1";
		$timelogresult = $DAO->select($sql);
		if($timelogresult[0]['id'])
		{
			$now = date('Y-m-d H:i:s');	
			$sql = "UPDATE `timelog_manage` SET `logout`= '$now' WHERE `id`=".$timelogresult[0]['id'];
			$DAO->query($sql);
		}	
        session_destroy();
        header("Location:login.php");
        die();
    }
?>