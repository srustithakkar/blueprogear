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

if(!$_SESSION['user_permission']['report']['view'])
{
	header("Location: permissionerror.php");
	die();
}

$venueobj = (object) new venue();
$paymentobj = (object) new payment();
$userobj = (object) new user();
$venueresult = $venueobj->venueidnamelist();

if($_SESSION['user']['user_type']==1 || $_SESSION['user']['user_type']==4)
$managerresult = $userobj->manageridnamelist();

$result = $paymentobj->paymentlist();


?>