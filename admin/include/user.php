<?php
require_once ("system/config.php");
include "resize.php";
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
$ethinicityobj = (object) new ethinicity();
if(isset($_REQUEST['add']))
{
	if(!$_SESSION['user_permission']['user']['add'])
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
			header('location:user.php?add=true&msg=4');
         	die();
		}
		
		if(!$userobj->emailcheck($_REQUEST['email']))
		{
			header('location:user.php?add=true&msg=1');
			die();
		}
		
    	
		$lastname  = inputString($_REQUEST['lastname']);
		$email     = inputString($_REQUEST['email']);
		//$dob       = inputString($_REQUEST['dob']);
		
		$datearray = explode('-',$_REQUEST['dob']);
		$dob = "$datearray[2]-$datearray[0]-$datearray[1]";
		
		$gender    = inputString($_REQUEST['gender']);
		$contact_no =inputString($_REQUEST['contact_no']);
		$password = pass_encrypt($_REQUEST['password']);
		$ethinicity = inputString($_REQUEST['ethinicity']);;
		$usertype = 3;
		
		$imagefilename = '';
		if($_REQUEST['single_image'] !='')
		{
			$imagefilename = $_REQUEST['single_image'];
			copy("tempimage/$imagefilename", "uploads/".$imagefilename);
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			
			$extenstionremove = explode('.',$imagefilename);
			$simpimage = new SimpleImage();
			$simpimage->load("uploads/crop/".$imagefilename);
			$simpimage->resize(18,18);
			$simpimage->save("pinimage/resize_".$extenstionremove[0].".png");
			$baseimagename = "pinimage/resize_".$extenstionremove[0].".png";
			pinimage_map($baseimagename,"pinimage/user_pin.png","pinimage/".$extenstionremove[0].".png");
			
			
			
			$bigimage = new SimpleImage();
			$bigimage->load("uploads/crop/".$imagefilename);
			$bigimage->resize(75,75);
			$bigimage->save("pinimage/resizebig_".$extenstionremove[0].".png");
			$bigimagename = "pinimage/resizebig_".$extenstionremove[0].".png";
			pinimage($bigimagename,"pinimage/big_user_pin.png","pinimage/big_".$extenstionremove[0].".png");
			
			
			unlink($baseimagename);
			unlink($bigimagename);
			unlink("tempimage/$imagefilename");
			unlink("tempimage/crop/$imagefilename");
		}
		if($userobj->add($firstname,$lastname,$email,$dob,$gender,$contact_no,$password,$imagefilename,$usertype,$ethinicity))
		{
			
			$logmsg = "Added new user '$firstname $lastname'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
				
			header('Location: user.php?msg=2');
			die();
		}
		else
		{
			header('location:user.php?add=true&msg=4');
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
		$ethinicity = inputString($_REQUEST['ethinicity']);
		
		
		if($_REQUEST['single_image'] !='')
		{
				$imagefilename = $_REQUEST['single_image'];
				copy("tempimage/$imagefilename", "uploads/".$imagefilename);
				copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
				
				$extenstionremove = explode('.',$imagefilename);
				$simpimage = new SimpleImage();
				$simpimage->load("uploads/crop/".$imagefilename);
				$simpimage->resize(18,18);
				$simpimage->save("pinimage/resize_".$extenstionremove[0].".png");
				$baseimagename = "pinimage/resize_".$extenstionremove[0].".png";
				pinimage_map($baseimagename,"pinimage/user_pin.png","pinimage/".$extenstionremove[0].".png");
			
				
				
				$bigimage = new SimpleImage();
				$bigimage->load("uploads/crop/".$imagefilename);
				$bigimage->resize(75,75);
				$bigimage->save("pinimage/resizebig_".$extenstionremove[0].".png");
				$bigimagename = "pinimage/resizebig_".$extenstionremove[0].".png";
				pinimage($bigimagename,"pinimage/big_user_pin.png","pinimage/big_".$extenstionremove[0].".png");
				
				unlink($baseimagename);
				unlink($bigimagename);
				unlink("tempimage/$imagefilename");
				unlink("tempimage/crop/$imagefilename");
				
				
				
				if($_REQUEST['imagename']!='')
				{
					$previouspin = explode('.',$_REQUEST['imagename']);
					unlink("uploads/".$_REQUEST['imagename']);
					unlink("uploads/crop/".$_REQUEST['imagename']);
					unlink("pinimage/".$previouspin[0].".png");
					unlink("pinimage/big_".$previouspin[0].".png");
				}	
				
		}
		
		
		
		if($userobj->edituser($firstname,$lastname,$email,$dob,$gender,$contact_no,$user_id,$imagefilename,$ethinicity))
		{
				$logmsg = "Edited user '$firstname $lastname'";
			    activitylog($_SESSION['user']['user_id'],$logmsg);
			
				header('Location:user.php?msg=3');
				die();
		}
		else
		{
				header('Location:user.php?msg=4');
				die();	
		}
}
    
if(isset($_REQUEST['delete_user']))
{
		if(!$_SESSION['user_permission']['user']['delete'])
		{
			header("Location: permissionerror.php");
         	die();
		}
    	if($userobj->delete())
		{
			header('Location:user.php?msg=8');
			die();  
		}
}
if (isset($_REQUEST['edit']))
{
		
	if(basename($_SERVER['PHP_SELF']) == "user.php")
		{
			if(!$_SESSION['user_permission']['user']['edit'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		if(basename($_SERVER['PHP_SELF']) == "userinfo.php")
		{
			if(!$_SESSION['user_permission']['user']['view'])
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
		header('location:user.php?add=true&msg=4');
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
			header('location:user.php?msg=11');
			die;
		}
		else
		{
			header('location:user.php?msg=4');
			die();
		}	
	}
	else
	{
		header('location:user.php?msg=4');
		die();
	}	
}
$result = $userobj->userlist();
$ethinicity_array = $ethinicityobj->ethinicitylist();

?>