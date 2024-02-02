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

$userobj = (object) new user();



if(isset($_REQUEST['add']))
{
	if(!$_SESSION['user_permission']['manager']['add'])
	{
			header("Location: permissionerror.php");
         	die();
	}
}

if(isset($_REQUEST['add_user']))
{
		$firstname = inputString($_REQUEST['firstname']);
		if($firstname=="")
		{
			header('location:manager.php?add=true&msg=4');
         	die();
		}
		
		if(!$userobj->emailcheck($_REQUEST['email']))
		{
			header('location:manager.php?add=true&msg=1');
			die();
		}
		
    	
		$lastname  = inputString($_REQUEST['lastname']);
		$email     = inputString($_REQUEST['email']);
		$contact_no =inputString($_REQUEST['contact_no']);
		$password = pass_encrypt($_REQUEST['password']);
		$usertype = 2;
		$imagefilename = '';
		if($_REQUEST['single_image'] !='')
		{
			$imagefilename = $_REQUEST['single_image'];
			copy("tempimage/$imagefilename", "uploads/".$imagefilename);
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			unlink("tempimage/$imagefilename");
			unlink("tempimage/crop/$imagefilename");
		}
		$response = $userobj->manageradd($firstname,$lastname,$email,$contact_no,$password,$imagefilename,$usertype);
		if($response['STATUS'])
		{
				$logmsg = "Added new manager '$firstname $lastname'";
				activitylog($_SESSION['user']['user_id'],$logmsg);
				header('Location: manager.php?msg=2');
				die();
		}		
		else
		{
				header('location:manager.php?add=true&msg=4');
				die();
		}
				
}
    
if(isset($_REQUEST['update_user']))
{
		
		$imagefilename = $_REQUEST['imagename'];
		$firstname = inputString($_REQUEST['firstname']);
		$lastname  = inputString($_REQUEST['lastname']);
		$email     = inputString($_REQUEST['email']);
		$datearray = explode('-',$_REQUEST['dob']);
		$dob = "$datearray[2]-$datearray[0]-$datearray[1]";
		$gender    = inputString($_REQUEST['gender']);
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
			$logmsg = "Edited manager '$firstname $lastname'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location:manager.php?msg=3');
			die();
		}
		else
		{
			header('Location:manager.php?msg=4');
			die();	
		}		
		
}
    
if(isset($_REQUEST['delete_user']))
{
	
	if(!$_SESSION['user_permission']['manager']['delete'])
	{
			header("Location: permissionerror.php");
         	die();
	}
    	if($userobj->delete())
		{
			header('Location:manager.php?msg=8');
			die();  
		}
}
if (isset($_REQUEST['edit']))
{
			
		if(basename($_SERVER['PHP_SELF']) == "manager.php")
		{
			if(!$_SESSION['user_permission']['manager']['edit'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		if(basename($_SERVER['PHP_SELF']) == "managerinfo.php")
		{
			if(!$_SESSION['user_permission']['manager']['view'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		
	
	$user_editid = inputString(trim($_REQUEST['edit']));
	if($user_editid !='' && is_numeric($user_editid))
	{
		$result_edit = $userobj->userdetailbyid($user_editid);
	}
	else
	{
		header('location:manager.php?add=true&msg=4');
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
			header('location:manager.php?msg=11');
			die;
		}
		else
		{
			header('location:manager.php?msg=4');
			die();
		}	
	}
	else
	{
		header('location:manager.php?msg=4');
		die();
	}	
}
$result = $userobj->managervenuelist();

?>