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
$venueobj = (object) new venue();
if (isset($_REQUEST['edit']))
{
	if(!$_SESSION['user_permission']['venue']['view'])
	{
			header("Location: permissionerror.php");
         	die();
	}	
	
	$venue_editid = inputString(trim($_REQUEST['edit']));
	if($venue_editid !='' && is_numeric($venue_editid))
	{
		$result_edit = $venueobj->venuedetailbyidinfo($venue_editid);
		$dayselected = $venueobj->daylistselectedvenue($venue_editid);
		$imageselected  = $venueobj->venueimages($venue_editid);
		$userimageselected  = $venueobj->uservenueimages($venue_editid);
	}
}
if(!count($result_edit))
{
	header('location:venue.php?msg=4');
	die();
}
?>