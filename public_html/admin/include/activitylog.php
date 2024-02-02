<?php
require_once ("system/config.php");
if(count($_SESSION['user'])==0){
	header("Location: login.php");
    die();
}else{
    $result = checkUserToken();	
   if(!$result){
  		 header("Location: logout.php?token=invalid");
         die();
    }
}

if($_SESSION['user']['user_type'] !=1)
{
	header("Location: permissionerror.php");
	die();
}

 global $DAO;
 $sql = "SELECT a . * , u.firstname, u.lastname, u.user_type FROM `activitylog` a LEFT JOIN user u ON a.user_id = u.user_id ORDER BY a.id DESC";
 $result = $DAO->select($sql);
 
 
 

?>