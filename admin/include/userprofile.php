<?php
require_once ("system/config.php");
error_reporting(0);
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
$userobj = (object) new user();


if(isset($_REQUEST['action']) && $_REQUEST['action']=='check_userpass')
{
	$finalArray = array();
	$password = $_REQUEST['password'];
	$result = $userobj->userdetailbyid($_SESSION['user']['user_id']);
	if(base64_encode($password)==$result[0]['password']) {
	$finalArray['STATUS'] = "1";
	}
	else
	{
		$finalArray['STATUS'] = "0";
	}
	$json = json_encode($finalArray);
	echo $json;
	die;
}			

if(isset($_REQUEST['passwordchange']))
{
	if($_REQUEST['new_password'] == $_REQUEST['conf_password'])
	{
		if($userobj->changePassword($_SESSION['user']['user_id'],base64_encode($_REQUEST['new_password'])))
		{
				header('Location:userprofile.php?msg=7');
				die();	
		}	
		else
		{
				header('Location:userprofile.php?msg=4');
				die();	
		}		
	}
	else
	{
			header('Location:userprofile.php?msg=4');
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
				
			$_SESSION['user']['firstname'] = stripcslashes($firstname);
			$_SESSION['user']['lastname'] = stripcslashes($lastname);
			$_SESSION['user']['photo'] = $imagefilename;
			$logmsg = "Profile edited";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			header('Location:userprofile.php?msg=3');
			die();
		}
		else
		{
			header('Location:userprofile.php?msg=4');
			die();	
		}
}
    

$result_edit = $userobj->userdetailbyid($_SESSION['user']['user_id']);
?>