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

$userobj = (object) new user();
if(isset($_REQUEST['add_user']))
{
		$firstname = inputString($_REQUEST['firstname']);
		if($firstname=="")
		{
			header('location:subadmin.php?add=true&msg=4');
         	die();
		}
		if(!$userobj->emailcheck($_REQUEST['email']))
		{
			header('location:subadmin.php?add=true&msg=1');
			die();
		}
		
    	
		$lastname  = inputString($_REQUEST['lastname']);
		$email     = inputString($_REQUEST['email']);
		$contact_no =inputString($_REQUEST['contact_no']);
		$password = pass_encrypt($_REQUEST['password']);
		$usertype = 4;
		
		
		$venueperms = getArrayVal($_POST, "permissions_venue");
		$venueperms = $userobj->permissionsanitizeArray($venueperms);
		$venue_perm_serialize = serialize($venueperms);
		
		
		$categoryperms = getArrayVal($_POST, "permissions_category");
		$categoryperms = $userobj->permissionsanitizeArray($categoryperms);
		$category_perm_serialize = serialize($categoryperms);
		
		
		$dealperms = getArrayVal($_POST, "permissions_deal");
		$dealperms = $userobj->permissionsanitizeArray($dealperms);
		$deal_perm_serialize = serialize($dealperms);
		
		
		
		$dealperms = getArrayVal($_POST, "permissions_deal");
		$dealperms = $userobj->permissionsanitizeArray($dealperms);
		$deal_perm_serialize = serialize($dealperms);
		
		
		$discountperms = getArrayVal($_POST, "permissions_discount");
		$discountperms = $userobj->permissionsanitizeArray($discountperms);
		$discount_perm_serialize = serialize($discountperms);
		
		
		$ethinicityperms = getArrayVal($_POST, "permissions_ethinicity");
		$ethinicityperms = $userobj->permissionsanitizeArray($ethinicityperms);
		$ethinicity_perm_serialize = serialize($ethinicityperms);
		
		
		$managerperms = getArrayVal($_POST, "permissions_manager");
		$managerperms = $userobj->permissionsanitizeArray($managerperms);
		$manager_perm_serialize = serialize($managerperms);
		
		
		
		
		$venueemployeeperms = getArrayVal($_POST, "permissions_venueemployee");
		$venueemployeeperms = $userobj->permissionsanitizeArray($venueemployeeperms);
		$venueemployee_perm_serialize = serialize($venueemployeeperms);
		
		
		
		$userperms = getArrayVal($_POST, "permissions_user");
		$userperms = $userobj->permissionsanitizeArray($userperms);
		$user_perm_serialize = serialize($userperms);
		
		
		$packageperms = getArrayVal($_POST, "permissions_package");
		$packageperms = $userobj->permissionsanitizeArray($packageperms);
		$package_perm_serialize = serialize($packageperms);
		
		
		
		
		$reportperms = getArrayVal($_POST, "permissions_report");
		$reportperms = $userobj->permissionsanitizeArray($reportperms);
		$report_perm_serialize = serialize($reportperms);
		
		
		
		$mailperms = getArrayVal($_POST, "permissions_mail");
		$mailperms = $userobj->permissionsanitizeArray($mailperms);
		$mail_perm_serialize = serialize($mailperms);
		
		
		$imagefilename = '';
		if($_REQUEST['single_image'] !='')
		{
			$imagefilename = $_REQUEST['single_image'];
			copy("tempimage/$imagefilename", "uploads/".$imagefilename);
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			unlink("tempimage/$imagefilename");
			unlink("tempimage/crop/$imagefilename");
		}
		$parent_user_id = $_SESSION['user']['user_id'];
		$response = $userobj->employeeadd($firstname,$lastname,$email,$contact_no,$password,$imagefilename,$usertype,$parent_user_id);
		if($response['STATUS'])
		{
				$user_id = $response['RESULT']['inserted_id'];
				$permission = array();
				$permission['user_id'] = $user_id;
				$permission['venue'] = $venue_perm_serialize;
				$permission['manager'] = $manager_perm_serialize;
				$permission['user'] = $user_perm_serialize;
				$permission['category'] = $category_perm_serialize;
				$permission['package'] = $package_perm_serialize;
				$permission['report'] = $report_perm_serialize;
				$permission['offer_of_venue'] = $deal_perm_serialize;
				$permission['notification'] = $mail_perm_serialize;
				$permission['discount'] = $discount_perm_serialize;
				$permission['venueemployee'] = $venueemployee_perm_serialize;
				$permission['ethinicity'] = $ethinicity_perm_serialize;
				
				$userobj->permissiontableinsert($permission);
				
				
				$logmsg = "Added new admin employee '$firstname $lastname'";
				activitylog($_SESSION['user']['user_id'],$logmsg);
				
				header('Location: subadmin.php?msg=2');
				die();
		}
		else
		{
				header('location:subadmin.php?add=true&msg=4');
				die();
		}
				
}
    
if(isset($_REQUEST['update_user']))
{
		
		$imagefilename = $_REQUEST['imagename'];
		$firstname = inputString($_REQUEST['firstname']);
		$lastname  = inputString($_REQUEST['lastname']);
		$email     = inputString($_REQUEST['email']);
		$contact_no =inputString($_REQUEST['contact_no']);
		$user_id = inputString($_REQUEST['user_id']);
		
		
		
		
		
		$venueperms = getArrayVal($_POST, "permissions_venue");
		$venueperms = $userobj->permissionsanitizeArray($venueperms);
		$venue_perm_serialize = serialize($venueperms);
		
		
		$categoryperms = getArrayVal($_POST, "permissions_category");
		$categoryperms = $userobj->permissionsanitizeArray($categoryperms);
		$category_perm_serialize = serialize($categoryperms);
		
		
		$dealperms = getArrayVal($_POST, "permissions_deal");
		$dealperms = $userobj->permissionsanitizeArray($dealperms);
		$deal_perm_serialize = serialize($dealperms);
		
		
		
		$dealperms = getArrayVal($_POST, "permissions_deal");
		$dealperms = $userobj->permissionsanitizeArray($dealperms);
		$deal_perm_serialize = serialize($dealperms);
		
		
		$discountperms = getArrayVal($_POST, "permissions_discount");
		$discountperms = $userobj->permissionsanitizeArray($discountperms);
		$discount_perm_serialize = serialize($discountperms);
		
		
		$ethinicityperms = getArrayVal($_POST, "permissions_ethinicity");
		$ethinicityperms = $userobj->permissionsanitizeArray($ethinicityperms);
		$ethinicity_perm_serialize = serialize($ethinicityperms);
		
		$managerperms = getArrayVal($_POST, "permissions_manager");
		$managerperms = $userobj->permissionsanitizeArray($managerperms);
		$manager_perm_serialize = serialize($managerperms);
		
		
		
		$venueemployeeperms = getArrayVal($_POST, "permissions_venueemployee");
		$venueemployeeperms = $userobj->permissionsanitizeArray($venueemployeeperms);
		$venueemployee_perm_serialize = serialize($venueemployeeperms);
		
		
		
		$userperms = getArrayVal($_POST, "permissions_user");
		$userperms = $userobj->permissionsanitizeArray($userperms);
		$user_perm_serialize = serialize($userperms);
		
		
		$packageperms = getArrayVal($_POST, "permissions_package");
		$packageperms = $userobj->permissionsanitizeArray($packageperms);
		$package_perm_serialize = serialize($packageperms);
		
		
		
		
		$reportperms = getArrayVal($_POST, "permissions_report");
		$reportperms = $userobj->permissionsanitizeArray($reportperms);
		$report_perm_serialize = serialize($reportperms);
		
		
		
		$mailperms = getArrayVal($_POST, "permissions_mail");
		$mailperms = $userobj->permissionsanitizeArray($mailperms);
		$mail_perm_serialize = serialize($mailperms);
		
		
		
		
		
		if($_REQUEST['single_image'] !='')
		{
			$imagefilename = $_REQUEST['single_image'];
			copy("tempimage/$imagefilename", "uploads/".$imagefilename);
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			
			unlink("tempimage/$imagefilename");
			unlink("tempimage/crop/$imagefilename");
				
			if($_REQUEST['imagename']!='')
			{
				unlink("uploads/".$_REQUEST['imagename']);
				unlink("uploads/crop/".$_REQUEST['imagename']);
			}
		}
			
		if($userobj->editmanger($firstname,$lastname,$email,$contact_no,$user_id,$imagefilename))
		{
				$userobj->permissiontabledelete($user_id);
				$permission = array();
				$permission['user_id'] = $user_id;
				$permission['venue'] = $venue_perm_serialize;
				$permission['manager'] = $manager_perm_serialize;
				$permission['user'] = $user_perm_serialize;
				$permission['category'] = $category_perm_serialize;
				$permission['package'] = $package_perm_serialize;
				$permission['report'] = $report_perm_serialize;
				$permission['offer_of_venue'] = $deal_perm_serialize;
				$permission['notification'] = $mail_perm_serialize;
				$permission['discount'] = $discount_perm_serialize;
				$permission['venueemployee'] = $venueemployee_perm_serialize;
				$permission['ethinicity'] = $ethinicity_perm_serialize;
				$userobj->permissiontableinsert($permission);
				
				
				$logmsg = "Edited admin employee '$firstname $lastname'";
				activitylog($_SESSION['user']['user_id'],$logmsg);
				header('Location:subadmin.php?msg=3');
				die();
		}
		else
		{
			header('Location:subadmin.php?msg=4');
			die();	
		}		
		
}
    
if(isset($_REQUEST['delete_user']))
{
    	if($userobj->delete())
		{
			header('Location:subadmin.php?msg=8');
			die();  
		}
}


if(isset($_REQUEST['deactive']))
{
    	if($userobj->deactivate($_REQUEST['deactive']))
		{
			header('Location:subadmin.php?msg=9');
			die();  
		}
}
if(isset($_REQUEST['active']))
{
    	if($userobj->activate($_REQUEST['active']))
		{
			header('Location:subadmin.php?msg=10');
			die();  
		}
}


if (isset($_REQUEST['edit']))
{
	$user_editid = inputString(trim($_REQUEST['edit']));
	if($user_editid !='' && is_numeric($user_editid))
	{
		$result_edit = $userobj->userdetailbyid($user_editid);
	}
	else
	{
		header('location:subadmin.php?add=true&msg=4');
		die();
	}	
}
if (isset($_REQUEST['request_password']))
{
	$user_editid = inputString(trim($_REQUEST['request_password']));
	if($user_editid !='' && is_numeric($user_editid))
	{
		$result_edit = $userobj->userdetailbyid($user_editid);
		if($result_edit[0]['email']!='')
		{
			$result = $userobj->requestpassword($result_edit[0]['user_id']);
			header('location:subadmin.php?msg=11');
			die;
		}
		else
		{
			header('location:subadmin.php?msg=4');
			die();
		}	
		
	}
	else
	{
		header('location:subadmin.php?msg=4');
		die();
	}	
}
$result = $userobj->subadminlist();

?>