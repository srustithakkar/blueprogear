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

if(!$_SESSION['user_permission']['discount']['add'])
{
	header("Location: permissionerror.php");
	die();
}	 
global $DAO;
if(isset($_REQUEST['add']))
{
	if($_REQUEST['type'] && $_REQUEST['value'])
	{
		$adddiscount = array();
		$adddiscount['venue_id'] = $_REQUEST['add'];
		$adddiscount['user_id'] = $_SESSION['user']['user_id'];
		$adddiscount['discount_id'] = $_REQUEST['type'];
		$adddiscount['value'] = $_REQUEST['value'];
		$adddiscount['created_on'] = date('Y-m-d H:i:s');
		
		if($adddiscount['discount_id']==1 || $adddiscount['discount_id'] == 2 || $adddiscount['discount_id'] == 3) 
			$adddiscount['subscription_id'] = 3;
		else
			$adddiscount['subscription_id'] = 2;
		
		
		if($adddiscount['discount_id']==3 ||$adddiscount['discount_id']==6)
		{
			
			$paymentobj = (object) new payment();
			$paymentobj->venuefreedaydiscount($adddiscount);
			
		}
		else
		{
			$DAO->insert('venue_discount',$adddiscount);	
		}
		
		
		$sql = "select name from venue where venue_id=".$adddiscount['venue_id'];
		$venuenameresult = $DAO->select($sql);
		$logmsg = "Added discount on venue '".$venuenameresult[0]['name']."'";
		activitylog($_SESSION['user']['user_id'],$logmsg);
		header("Location: discount.php?msg=1");
        die();
	}
	else
	{
		 header("Location: discount.php?msg=4");
         die();
	}	
}
if(isset($_REQUEST['deactive_venue']))
{
	$sql = "Delete from venue_discount where venue_id=".$_REQUEST['deactive_venue'];
	$result = $DAO->select($sql);
	
	$sql = "select name from venue where venue_id=".$_REQUEST['deactive_venue'];
	$venuenameresult = $DAO->select($sql);
	$logmsg = "Disable discount on venue '".$venuenameresult[0]['name']."'";
	activitylog($_SESSION['user']['user_id'],$logmsg);
	
	header("Location: discount.php?msg=2");
    die();
}

 $sql = "SELECT v . * , u.firstname, u.lastname, c.name AS categoryname, vd.discount_id, vd.value,d.name as discountname
			FROM venue v
			LEFT JOIN user u ON v.manager_id = u.user_id
			INNER JOIN category c ON v.category_id = c.id
			LEFT JOIN venue_discount vd ON v.venue_id = vd.venue_id
			LEFT JOIN discount d ON vd.discount_id = d.id
			WHERE v.status =1
			AND v.is_delete =0 AND v.recurring!=1 ORDER BY v.name";
 $result = $DAO->select($sql);
 
 $sql = "select * from discount";
 $discountarray = $DAO->select($sql); 
 
 $sql = "select * from subscriptions where is_delete=0";
 $subscriptionarray = $DAO->select($sql); 
 $venueobj = (object) new venue();
 
?>