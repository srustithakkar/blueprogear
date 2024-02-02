<?php
require_once ("system/config.php");
require_once("classes/paypal.class.php");
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
$userobj = (object) new user();
$countryobj = (object) new country();
$categoryobj = (object) new category();


if(isset($_REQUEST['add']))
{
	if(!$_SESSION['user_permission']['venue']['add'])
	{
			header("Location: permissionerror.php");
         	die();
	}
}




if(isset($_REQUEST['add_venue']))
{
		/* echo '<pre>';
		print_r($_REQUEST); die; */
		
		$data = array();
		$data['name'] = inputString($_REQUEST['name']);
		$data['email']     = inputString($_REQUEST['email']);
		$data['description'] = inputString($_REQUEST['description']);
		$data['highlighted_text']    = inputString($_REQUEST['highlighted_text']);
		$data['latitude'] =inputString($_REQUEST['latitude']);
		$data['longitude'] = inputString($_REQUEST['longitude']);
		$data['manager_id'] = inputString($_REQUEST['manager_id']);
		$data['category_id'] = inputString($_REQUEST['category_id']);
		//$data['street1'] = inputString($_REQUEST['street1']);
		//$data['street2'] = inputString($_REQUEST['street2']);
		//$data['zip'] = inputString($_REQUEST['zip']);
		//$data['city'] = inputString($_REQUEST['city']);
		//$data['state'] = inputString($_REQUEST['state']);
		//$data['country_id'] = inputString($_REQUEST['country_id']);
		
		$data['contact_no'] = inputString($_REQUEST['contact_no']);
		$data['imagefilename'] = '';
		$data['address'] = inputString($_REQUEST['address']);
		
		
		$data['notification'] = isset($_POST['notification']) && $_POST['notification']  ? 1 : 0;
		
		
		if($_REQUEST['single_image'] !='')
		{
	
			$imagefilename = $_REQUEST['single_image'];	
			copy("tempimage/".$imagefilename,"uploads/$imagefilename");
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			
			unlink("tempimage/".$imagefilename);
			unlink("tempimage/crop/".$imagefilename);
			
			$data['imagefilename'] = $imagefilename;
		}
		
		

		$response = $venueobj->add($data);
		if($response['STATUS']==1)
		{
			if($_POST['timing'])
			{
				foreach($_POST['timing'] as $k => $v) {
						
					if($v['start_time'] !="" and $v['end_time'] !="")
					{
						if(!isset($v['close']))
						{
							$venueobj->days($response['RESULT']['inserted_id'],$k,$v['start_time'],$v['end_time']);		
						}
					}
				}
			}
			
			$mutlipleimage  = $_REQUEST['multipleimagehidden'];
			if($mutlipleimage !='')
			{
				$mutlipleimage_array = explode(',', $mutlipleimage);
				foreach ($mutlipleimage_array as $value)
				{
					if($value !='')
					{
						$imagefilename = $value;
						copy("tempimage/".$imagefilename,"uploads/$imagefilename");
						copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
						
						unlink("tempimage/".$imagefilename);
						unlink("tempimage/crop/".$imagefilename);
						$venueobj->attachment($response['RESULT']['inserted_id'], $imagefilename);
					}	
				}
				
			}
			
			$logmsg = "Added new venue '".$data['name']."'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			$_SESSION['venueoperation'] = "add";
			header('Location: vpayment.php?edit='.$response['RESULT']['inserted_id']);
			die();
			
				//header('Location: venue.php?msg=2');
				//die();
			
		}
		else
		{
			header('location:venue.php?add=true&msg=4');
			die();
		}		
}
    
if(isset($_REQUEST['update_venue']))
{
		
		
		$imagefilename = $_REQUEST['imagename'];
		$venue_id = $_REQUEST['venue_id'];
		
		$updatearray['name'] = inputString($_REQUEST['name']);
		$updatearray['email']     = inputString($_REQUEST['email']);
		$updatearray['description'] = inputString($_REQUEST['description']);
		if(isset($_REQUEST['highlighted_text']))
		$updatearray['highlighted_text']    = inputString($_REQUEST['highlighted_text']);
		$updatearray['latitude'] =inputString($_REQUEST['latitude']);
		$updatearray['longitude'] = inputString($_REQUEST['longitude']);
		$updatearray['manager_id'] = inputString($_REQUEST['manager_id']);
		$updatearray['category_id'] = inputString($_REQUEST['category_id']);
		
		//$updatearray['street1'] = inputString($_REQUEST['street1']);
		//$updatearray['street2'] = inputString($_REQUEST['street2']);
		//$updatearray['zip'] = inputString($_REQUEST['zip']);
		//$updatearray['city'] = inputString($_REQUEST['city']);
		//$updatearray['state'] = inputString($_REQUEST['state']);
		//$updatearray['country_id'] = inputString($_REQUEST['country_id']);
		
		$updatearray['address'] = inputString($_REQUEST['address']);
		$updatearray['contact_no'] = inputString($_REQUEST['contact_no']);
		$updatearray['notification'] = isset($_POST['notification']) && $_POST['notification']  ? 1 : 0;
			
		if($_REQUEST['single_image'] !='')
		{
	
			$imagefilename = $_REQUEST['single_image'];	
			copy("tempimage/".$imagefilename,"uploads/$imagefilename");
			copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
			
			unlink("tempimage/".$imagefilename);
			unlink("tempimage/crop/".$imagefilename);
						
			$updatearray['business_logo'] = $imagefilename;
			unlink("uploads/".$_REQUEST['imagename']);
			unlink("uploads/crop/".$_REQUEST['imagename']);
			
		}

		$response =$venueobj->edit($updatearray,$venue_id); 
		
		if($response)
		{
			
			
			$mutlipleimage  = $_REQUEST['multipleimagehidden'];
			if($mutlipleimage !='')
			{
				$mutlipleimage_array = explode(',', $mutlipleimage);
				foreach ($mutlipleimage_array as $value)
				{
					if($value !='')
					{
						$imagefilename = $value;
						copy("tempimage/".$imagefilename,"uploads/$imagefilename");
						copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
						
						unlink("tempimage/".$imagefilename);
						unlink("tempimage/crop/".$imagefilename);
						$venueobj->attachment($venue_id, $imagefilename);
					}	
				}
				
			}
			
						 
			$venueobj->venuedaysdelete($venue_id);
			
			if($_POST['timing'])
			{
				foreach($_POST['timing'] as $k => $v) {
						
					if($v['start_time'] !="" and $v['end_time']!="")
					{
						if(!isset($v['close']))
						{
							$venueobj->days($venue_id,$k,$v['start_time'],$v['end_time']);		
						}
					}	
	   			 	
				}
			}
			
			$logmsg = "Edited venue '".$updatearray['name']."'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			$_SESSION['venueoperation'] = "edit";
			
			$venue_response = $venueobj->venuedetailbyid($venue_id);
			
			if($venue_response[0]['recurring'])
			{
				header('Location: venue.php?msg=3');
				die();
			}
			else
			{
				
				header('Location:vpayment.php?edit='.$venue_id);
				die();
			}		
			
		}
		else
		{
			
			header("Location:venue.php?edit=$_REQUEST[venue_id]&msg=6");
			die();	
		}	
		
}
    
if(isset($_REQUEST['delete_venue']))
{
		if(!$_SESSION['user_permission']['venue']['delete'])
		{
			header("Location: permissionerror.php");
         	die();
		}
		
		$venue_response = $venueobj->venuedetailbyid($_REQUEST['delete_venue']);
		
		if($venue_response[0]['recurring'])
		{
			$paypal= new MyPayPal();
			global $DAO;
			$padata = 	'&PROFILEID='.urlencode($venue_response[0]['recurring_profile_id']).'&ACTION=Cancel';
			$httpParsedResponseAr = $paypal->PPHttpPost('ManageRecurringPaymentsProfileStatus', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			$venue_update_array = array();
			$venue_update_array['recurring'] = 0;
			$venue_update_array['recurring_profile_id'] = '';
			$venue_update_array['recurring_subscription'] = 0;
			$where = array('venue_id'=>$venue_response[0]['venue_id']);
			$q = $DAO->update('venue',$venue_update_array,$where);
			$logmsg = "Canceled recurring account of '".$venue_response[0]['name']."'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
		}	
		if($venueobj->delete())
		{
			header('Location:venue.php?msg=8');
			die();  
		}
		
			
		
		
		
}
if (isset($_REQUEST['type'])&&isset($_REQUEST['vimageedit'])&&isset($_REQUEST['image_id'])&&isset($_REQUEST['status']))
{
	$imageid = inputString(trim($_REQUEST['image_id']));
	if($_REQUEST['type']=="venue")
	{
	
		$venueobj->ac_deactivevenueimages($imageid,$_REQUEST['status']);
				
	}	
	if($_REQUEST['type']=="user")
	{
		$venueobj->ac_deactiveuserimages($imageid,$_REQUEST['status']);
				
	}
	if($_REQUEST['status']=="active")
	{
			header('location:venue.php?edit='.$_REQUEST['vimageedit'].'&msg=10');
			die();
	}
	if($_REQUEST['status']=="deactive")
	{
			header('location:venue.php?edit='.$_REQUEST['vimageedit'].'&msg=11');
			die();
	}
		
}

if (isset($_REQUEST['edit']))
{
	if(!$_SESSION['user_permission']['venue']['edit'])
	{
			header("Location: permissionerror.php");
         	die();
	}		
	
	$venue_editid = inputString(trim($_REQUEST['edit']));
	if($venue_editid !='' && is_numeric($venue_editid))
	{
		$result_edit = $venueobj->venuedetailbyid($venue_editid);
		$dayselected = $venueobj->daylistselectedvenue($venue_editid);
		$imageselected  = $venueobj->venueimages($venue_editid);
		$userimageselected  = $venueobj->uservenueimages($venue_editid);
	}
	else
	{
		header('location:venue.php?add=true&msg=4');
		die();
	}	
}
if (isset($_REQUEST['approve']))
{
	
	if(!$_SESSION['user_permission']['venue']['suspend'])
	{
			header("Location: permissionerror.php");
         	die();
	}		
	
	$venue_approveid = inputString(trim($_REQUEST['approve']));
	if($venue_approveid !='' && is_numeric($venue_approveid))
	{	
		if($venueobj->venueactive($venue_approveid))
		{
			header('location:venue.php?msg=6');
			die();
		}
	}	
}	

if (isset($_REQUEST['suspend']))
{
	
	if(!$_SESSION['user_permission']['venue']['suspend'])
	{
			header("Location: permissionerror.php");
         	die();
	}	
		
	$venue_approveid = inputString(trim($_REQUEST['suspend']));
	if($venue_approveid !='' && is_numeric($venue_approveid))
	{	
		if($venueobj->venuesuspend($venue_approveid))
		{
			header('location:venue.php?msg=7');
			die();
		}
	}	
}	

if (isset($_REQUEST['deleteimage']))
{
	$venue_imageid = inputString(trim($_REQUEST['image_id']));
	if($venue_imageid !='' && is_numeric($venue_imageid))
	{	
		if($venueobj->deletevenueimages($venue_imageid))
		{
			echo "ok";
			die;
		}
	}	
	die;
}


$result = $venueobj->venuelist();

$dayarray = $venueobj->daylist();
$managerlist = $userobj->manageridnamelist();
$categorydata = $categoryobj->categorydropdown();
$countrydata = $countryobj->allcountry(); 
$paymentobj = (object) new payment();
$subscriptiontype = $paymentobj->subscriptionstype();

$subscriptionname = array();
foreach($subscriptiontype as $key => $value) {
	$subscriptionname[$value['id']] = $value['name'];
}
?>