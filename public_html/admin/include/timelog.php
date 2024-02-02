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
 $sql = "SELECT tl.user_id,SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,tl.login, tl.logout))) AS timespent ,u.firstname,u.lastname,u.user_type,u.email FROM `timelog_manage` tl LEFT JOIN user u on tl.user_id = u.user_id  where u.user_type !=1 group by tl.user_id ORDER BY u.firstname";
 $result = $DAO->select($sql);
 
 $dashboard = (object) new dashboard();
 $userresult = $dashboard->usermanager();
 $totalcheckout = $dashboard->totalcheckout();
 $result_venue = $dashboard->venuelist();
 
 

?>