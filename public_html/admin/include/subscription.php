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

$subscriptionobj = (object) new subscription();


if(isset($_REQUEST['add']))
{
	if(!$_SESSION['user_permission']['package']['add'])
	{
			header("Location: permissionerror.php");
         	die();
	}
}


if(isset($_REQUEST['add_user']))
{
		$postarray = array();
		$postarray['name'] = addslashes(trim($_REQUEST['name']));
		$postarray['description'] = addslashes(trim($_REQUEST['description']));
		$postarray['duration'] = addslashes(trim($_REQUEST['duration']));
		$postarray['price'] = addslashes(trim($_REQUEST['price']));
		$postarray['status'] = addslashes(trim($_REQUEST['status']));
		
		if($subscriptionobj->add($postarray))
		{
			$name = $postarray['name'];
			$logmsg = "Added new package '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location: subscription.php?msg=2');
			die();
		}
		else
		{
			header('location:subscription.php?add=true&msg=4');
			die();
		}	
}
    
if(isset($_REQUEST['update_user']))
{
		$postarray = array();
		$postarray['name'] = addslashes(trim($_REQUEST['name']));
		$postarray['description'] = addslashes(trim($_REQUEST['description']));
		$postarray['duration'] = addslashes(trim($_REQUEST['duration']));
		$postarray['price'] = addslashes(trim($_REQUEST['price']));
		$postarray['status'] = addslashes(trim($_REQUEST['status']));
		$id = addslashes(trim($_REQUEST['subscription_id']));
		
    	if($subscriptionobj->edit($postarray,$id))
		{
			$name = $postarray['name'];
			$logmsg = "Edited package '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location:subscription.php?msg=3');
			die();
		}
}
    
if(isset($_REQUEST['deactive_subscription']))
{
		
		if(!$_SESSION['user_permission']['package']['suspend'])
	{
			header("Location: permissionerror.php");
         	die();
	}
	
    	if($subscriptionobj->deactive())
		{
			header('Location:subscription.php?msg=5');
			die();  
		}
		else
		{
			header('Location:subscription.php?msg=4');
			die();  
			
		}	
}
if(isset($_REQUEST['delete_subscription']))
{
		
		if(!$_SESSION['user_permission']['package']['delete'])
	{
			header("Location: permissionerror.php");
         	die();
	}
    	if($subscriptionobj->delete())
		{
			header('Location:subscription.php?msg=7');
			die();  
		}
		else
		{
			header('Location:subscription.php?msg=4');
			die();  
			
		}	
}

if(isset($_REQUEST['active_subscription']))
{
		if(!$_SESSION['user_permission']['package']['suspend'])
	{
			header("Location: permissionerror.php");
         	die();
	}
    	if($subscriptionobj->activate())
		{
			header('Location:subscription.php?msg=6');
			die();  
		}
		else
		{
			header('Location:subscription.php?msg=4');
			die();  
			
		}	
}
if (isset($_REQUEST['edit']))
{
	
	
	if(basename($_SERVER['PHP_SELF']) == "subscription.php")
		{
			if(!$_SESSION['user_permission']['package']['edit'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		if(basename($_SERVER['PHP_SELF']) == "subscriptioninfo.php")
		{
			if(!$_SESSION['user_permission']['package']['view'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		
	$editid = inputString(trim($_REQUEST['edit']));
	if($editid !='' && is_numeric($editid))
	{
		$result_edit = $subscriptionobj->subscriptiondetailbyid($editid);
	}
	else
	{
		header('location:category.php?add=true&msg=4');
		die();
	}	
}
	
$result = $subscriptionobj->subscriptionlist();
?>