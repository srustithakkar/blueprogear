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

if(!$_SESSION['user_permission']['notification']['view']){
	
	header("Location: permissionerror.php");
	die();
	
}	
global $DAO;

if(isset($_REQUEST['action']))
{
		if($_REQUEST['action']=="venue")
		{
			$where = "";
			if($_REQUEST['state'])
			{
				$state = $_REQUEST['state'];
				$where = " AND address LIKE '%$state%'"; 
			}
			if($_REQUEST['category'])
			{
				$category = $_REQUEST['category'];
				$where .= " AND category_id='$category'"; 
			}
			
			$sql = "SELECT * FROM `venue` where is_delete=0 AND notification =1 $where";
			$venueresult = $DAO->select($sql);
			echo json_encode($venueresult);
			die;
					
		}
		
		if($_REQUEST['action']=="user")
		{
			$sql = "SELECT * FROM `user` where user_type=3 AND is_delete=0 AND notification =1 AND email !=''";
			if($_REQUEST['gender'])
			{
				$gender = $_REQUEST['gender'];
				$sql .= " AND gender='$gender' ";
			}	
			if($_REQUEST['ethinicity'])
			{
				$ethinicity = $_REQUEST['ethinicity'];
				$sql .= " AND ethinicity='$ethinicity' ";
			}	
			$userresult = $DAO->select($sql);
			echo json_encode($userresult);
			die;
		}
			
}

if(isset($_REQUEST['venue_email_submit']))
{
	if(count($_REQUEST['venue_email'])>0)
	{
		foreach ($_REQUEST['venue_email'] as  $value)
		{
			$sql = "SELECT email FROM `venue` where venue_id='$value'";
			$venueemailresult = $DAO->select($sql);
			$notification_email = str_replace("[#DESCRIPTION#]", $_REQUEST['description'], $notification_email);
			$subject = $_REQUEST['subject'];
			$result = send_mail(ADMIN_EMAIL,$venueemailresult[0]['email'],$subject,$notification_email);
			
		}
		$logmsg = "Venue notification sent";
		activitylog($_SESSION['user']['user_id'],$logmsg);
		header("Location: notification.php?msg=1");
	}
	else
	{
		header("Location: notification.php?msg=4");
	}	
	
	
}
if(isset($_REQUEST['user_email_submit']))
{
	if(count($_REQUEST['user_email'])>0)
	{
		
		foreach ($_REQUEST['user_email'] as  $value)
		{
			$sql = "SELECT email FROM `user` where user_id='$value'";
			$useremailresult = $DAO->select($sql);
			$notification_email = str_replace("[#DESCRIPTION#]", $_REQUEST['description_user'], $notification_email);
			$subject = $_REQUEST['subject_user'];
			$result = send_mail(ADMIN_EMAIL,$useremailresult[0]['email'],$subject,$notification_email);
			
		}
		$logmsg = "User notification sent";
		activitylog($_SESSION['user']['user_id'],$logmsg);
		header("Location: notification.php?msg=2");
	}
	else
	{
		header("Location: notification.php?msg=4");
	}	
	
	
}

    
$sql = "SELECT * FROM `user` where user_type=3 AND is_delete=0 AND notification =1 AND email !='' order by firstname";
$userresult = $DAO->select($sql);


$sql = "SELECT * FROM `venue` where is_delete=0 AND notification =1 order by name";
$venueresult = $DAO->select($sql);


$userdata = $userresult;
$venuedata = $venueresult;
$categoryobj = (object) new category();
$categorydata = $categoryobj->categorydropdown();
$ethinicityobj = (object) new ethinicity();
$ethinicity_array = $ethinicityobj->ethinicitylist();


?>