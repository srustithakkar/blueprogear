<?php

include "resize.php";
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

$categoryobj = (object) new category();

if(isset($_REQUEST['add']))
{
	if(!$_SESSION['user_permission']['category']['add'])
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
			header('location:category.php?add=true&msg=4');
			die();
		}
		$description = addslashes(trim($_REQUEST['description']));
		$imagefilename = '';
		if($_REQUEST['single_image'] !='')
		{
			$imagefilename = $_REQUEST['single_image'];
			copy("tempimage/$imagefilename", "uploads/".$imagefilename);
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			unlink("tempimage/$imagefilename");
			unlink("tempimage/crop/$imagefilename");
			
		}
		$result = $categoryobj->add($name,$description,$imagefilename);
		if($result)
		{
			if($_REQUEST['single_image'] !='')
			{
				$category_id = $result;
				
				$extenstionremove = explode('.',$imagefilename);
				$simpimage = new SimpleImage();
				$simpimage->load("uploads/crop/".$imagefilename);
				$simpimage->resize(75,75);
			 	$simpimage->save("categoryimage/resize_".$extenstionremove[0].".png");
				$baseimagename = "categoryimage/resize_".$extenstionremove[0].".png";
				
				
				
				$mappinimage = new SimpleImage();
				$mappinimage->load("uploads/crop/".$imagefilename);
				$mappinimage->resize(18,18);
			 	$mappinimage->save("categoryimage/mapresize_".$extenstionremove[0].".png");
				$mapbaseimagename = "categoryimage/mapresize_".$extenstionremove[0].".png";
				
				
				
				$package_array = $categoryobj->packagelist();
				
				
				
				
					pinimage($baseimagename,"categoryimage/1_on.png","categoryimage/1_".$category_id."_on.png");
					pinimage($baseimagename,"categoryimage/1_off.png","categoryimage/1_".$category_id."_off.png");
					pinimage_map($mapbaseimagename,"categoryimage/1_map_on.png","categoryimage/1_".$category_id."_map_on.png");
					pinimage_map($mapbaseimagename,"categoryimage/1_map_off.png","categoryimage/1_".$category_id."_map_off.png");
				
				foreach ($package_array as $value) {
					pinimage($baseimagename,"categoryimage/".$value['id']."_on.png","categoryimage/".$value['id']."_".$category_id."_on.png");
					pinimage($baseimagename,"categoryimage/".$value['id']."_off.png","categoryimage/".$value['id']."_".$category_id."_off.png");
					pinimage_map($mapbaseimagename,"categoryimage/".$value['id']."_map_on.png","categoryimage/".$value['id']."_".$category_id."_map_on.png");
					pinimage_map($mapbaseimagename,"categoryimage/".$value['id']."_map_off.png","categoryimage/".$value['id']."_".$category_id."_map_off.png");
				}
				unlink($baseimagename);
				unlink($mapbaseimagename);
				
			}	
			$logmsg = "Added new category '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location: category.php?msg=2');
			die();
		}
		else
		{
			header('location:category.php?add=true&msg=4');
			die();
		}
	
}
    
if(isset($_REQUEST['update_category']))
{
	
		$category_id = $_REQUEST['category_id'];
		$updatearray['name'] = strip_tags(addslashes(trim($_REQUEST['name'])));
		$updatearray['description'] = addslashes(trim($_REQUEST['description']));
		$updatearray['created'] = date('Y-m-d h:i:s');
		
		if($_REQUEST['single_image'] !='')
		{
				$imagefilename = $_REQUEST['single_image'];	
				$updatearray['image'] = $_REQUEST['single_image'];
				copy("tempimage/$imagefilename", "uploads/".$imagefilename);
				copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			
				unlink("tempimage/$imagefilename");
				unlink("tempimage/crop/$imagefilename");
			
				
				
				$extenstionremove = explode('.',$imagefilename);
				$simpimage = new SimpleImage();
				$simpimage->load("uploads/crop/".$imagefilename);
				$simpimage->resize(75,75);
			 	$simpimage->save("categoryimage/resize_".$extenstionremove[0].".png");
				$baseimagename = "categoryimage/resize_".$extenstionremove[0].".png";
				
				
				$mappinimage = new SimpleImage();
				$mappinimage->load("uploads/crop/".$imagefilename);
				$mappinimage->resize(18,18);
			 	$mappinimage->save("categoryimage/mapresize_".$extenstionremove[0].".png");
				$mapbaseimagename = "categoryimage/mapresize_".$extenstionremove[0].".png";
				
				
				
				
				$package_array = $categoryobj->packagelist();
				
				
				pinimage($baseimagename,"categoryimage/1_on.png","categoryimage/1_".$category_id."_on.png");
					pinimage($baseimagename,"categoryimage/1_off.png","categoryimage/1_".$category_id."_off.png");
					pinimage_map($mapbaseimagename,"categoryimage/1_map_on.png","categoryimage/1_".$category_id."_map_on.png");
					pinimage_map($mapbaseimagename,"categoryimage/1_map_off.png","categoryimage/1_".$category_id."_map_off.png");
					
				foreach ($package_array as $value) {
				
					pinimage($baseimagename,"categoryimage/".$value['id']."_on.png","categoryimage/".$value['id']."_".$category_id."_on.png");
					pinimage($baseimagename,"categoryimage/".$value['id']."_off.png","categoryimage/".$value['id']."_".$category_id."_off.png");
					pinimage_map($mapbaseimagename,"categoryimage/".$value['id']."_map_on.png","categoryimage/".$value['id']."_".$category_id."_map_on.png");
					pinimage_map($mapbaseimagename,"categoryimage/".$value['id']."_map_off.png","categoryimage/".$value['id']."_".$category_id."_map_off.png");
				}
				
				
				if($_REQUEST['imagename']!='')
				{
					unlink("uploads/".$_REQUEST['imagename']);
					unlink("uploads/crop/".$_REQUEST['imagename']);
					unlink("categoryimage/resize_".$extenstionremove[0].".png");
					unlink("categoryimage/mapresize_".$extenstionremove[0].".png");
				}	
		}
		
		if($categoryobj->edit($updatearray,$category_id))
		{
			$name = $updatearray['name'];
			$logmsg = "Edited category '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location:category.php?msg=3');
			die();
		}
		else
		{
			header('Location:category.php?msg=4');
			die();
		}	
	
}
    
if(isset($_REQUEST['deactive_category']))
{
	
		if(!$_SESSION['user_permission']['category']['suspend'])
	{
			header("Location: permissionerror.php");
         	die();
	}
    	if($categoryobj->deactivate())
		{
			header('Location:category.php?msg=5');
			die();  
		}
		else
		{
			header('Location:category.php?msg=4');
			die();  
			
		}	
}


if(isset($_REQUEST['delete_category']))
{
		if(!$_SESSION['user_permission']['category']['delete'])
	{
			header("Location: permissionerror.php");
         	die();
	}
    	if($categoryobj->delete())
		{
			header('Location:category.php?msg=7');
			die();  
		}
		else
		{
			header('Location:category.php?msg=4');
			die();  
		}	
}



if(isset($_REQUEST['active_category']))
{
		if(!$_SESSION['user_permission']['category']['suspend'])
	{
			header("Location: permissionerror.php");
         	die();
	}
    	if($categoryobj->activate())
		{
			header('Location:category.php?msg=6');
			die();  
		}
		else
		{
			header('Location:category.php?msg=4');
			die();  
			
		}	
}
if (isset($_REQUEST['edit']))
{
	
	if(basename($_SERVER['PHP_SELF']) == "category.php")
		{
			if(!$_SESSION['user_permission']['category']['edit'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}
		if(basename($_SERVER['PHP_SELF']) == "categoryinfo.php")
		{
			if(!$_SESSION['user_permission']['category']['view'])
			{
				header("Location: permissionerror.php");
	         	die();
			}
		}


	$cat_editid = inputString(trim($_REQUEST['edit']));
	if($cat_editid !='' && is_numeric($cat_editid))
	{
		$result_edit = $categoryobj->categorydetailbyid($cat_editid);
	}
	else
	{
		header('location:category.php?add=true&msg=4');
		die();
	}	
}
	
$result = $categoryobj->categorylist();
?>