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

$ethinicityobj = (object) new ethinicity();

if(isset($_REQUEST['add']))
{
	if(!$_SESSION['user_permission']['ethinicity']['add'])
	{
			header("Location: permissionerror.php");
         	die();
	}
}

if(isset($_REQUEST['add_category']))
{
	    $name = strip_tags(addslashes(trim($_REQUEST['name'])));
		if($name == "")
		{
			header('location:ethinicity.php?add=true&msg=4');
			die();
		}
		$result = $ethinicityobj->add($name);
		if($result)
		{
			$logmsg = "Added new ethinicity '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location: ethinicity.php?msg=2');
			die();
		}
		else
		{
			header('location:ethinicity.php?add=true&msg=4');
			die();
		}
	
}
    
if(isset($_REQUEST['update_category']))
{
	    $updatearray = array();  
		$ethinicity_id = $_REQUEST['ethinicity_id'];
		$updatearray['name'] = strip_tags(addslashes(trim($_REQUEST['name'])));
		
		if($ethinicityobj->edit($updatearray,$ethinicity_id))
		{
			$name = $updatearray['name'];
			$logmsg = "Edited ethinicity '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			header('Location:ethinicity.php?msg=3');
			die();
		}
		else
		{
			header('Location:ethinicity.php?msg=4');
			die();
		}	
	
}
    

if(isset($_REQUEST['delete_ethinicity']))
{
		if(!$_SESSION['user_permission']['ethinicity']['delete'])
		{
			header("Location: permissionerror.php");
         	die();
		}
    	if($ethinicityobj->delete())
		{
			header('Location:ethinicity.php?msg=7');
			die();  
		}
		else
		{
			header('Location:ethinicity.php?msg=4');
			die();  
		}	
}



if (isset($_REQUEST['edit']))
{
	
	if(basename($_SERVER['PHP_SELF']) == "ethinicity.php")
		{
			if(!$_SESSION['user_permission']['ethinicity']['edit'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		if(basename($_SERVER['PHP_SELF']) == "ethinicityinfo.php")
		{
			if(!$_SESSION['user_permission']['ethinicity']['view'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}


	$cat_editid = inputString(trim($_REQUEST['edit']));
	if($cat_editid !='' && is_numeric($cat_editid))
	{
		$result_edit = $ethinicityobj->ethinicitydetailbyid($cat_editid);
	}
	else
	{
		header('location:ethinicity.php?add=true&msg=4');
		die();
	}	
}
	
$result = $ethinicityobj->ethinicitylist();
?>