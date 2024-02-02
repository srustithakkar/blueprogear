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

$offerobj = (object) new offer();
$venueobj = (object) new venue();
if(isset($_REQUEST['add_offer']))
{
		$data['name'] = addslashes(trim($_REQUEST['name']));
		
		if($data['name'] == "")
		{
			header('location:offer.php?add=true&msg=4');
         	die();
		}
		
		$data['description'] = addslashes(trim($_REQUEST['description']));
		$data['venue_id'] = addslashes(trim($_REQUEST['venue_id']));
		
		//$data['start'] = addslashes(trim($_REQUEST['start_date']));
		$datestartarray = explode('-',$_REQUEST['start_date']);
		$data['start'] = "$datestartarray[2]-$datestartarray[0]-$datestartarray[1]";
		
		//$data['end'] = addslashes(trim($_REQUEST['end_date']));
		$dateendarray = explode('-',$_REQUEST['end_date']);
		$data['end'] = "$dateendarray[2]-$dateendarray[0]-$dateendarray[1]";
		
		if($offerobj->add($data))
		{
			$name = $data['name'];
			$logmsg = "Added new offer '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
			
			header('Location: offer.php?msg=2');
			die();
		}
		else
		{
			header('location:offer.php?add=true&msg=4');
			die();
		}
			
}
    
if(isset($_REQUEST['update_offer']))
{
		$offer_id = $_REQUEST['id'];
		$updatearray['name'] = addslashes(trim($_REQUEST['name']));
		$updatearray['venue_id'] = addslashes(trim($_REQUEST['venue_id']));
		$updatearray['description'] = addslashes(trim($_REQUEST['description']));
		//$data['start'] = addslashes(trim($_REQUEST['start_date']));
		$datestartarray = explode('-',$_REQUEST['start_date']);
		$updatearray['start'] = "$datestartarray[2]-$datestartarray[0]-$datestartarray[1]";
		
		//$data['end'] = addslashes(trim($_REQUEST['end_date']));
		$dateendarray = explode('-',$_REQUEST['end_date']);
		$updatearray['end'] = "$dateendarray[2]-$dateendarray[0]-$dateendarray[1]";
		
		if($offerobj->edit($updatearray,$offer_id))
		{
			$name = $updatearray['name'];
			$logmsg = "Edited offer '$name'";
			activitylog($_SESSION['user']['user_id'],$logmsg);
				
			header('Location:offer.php?msg=3');
			die();
		}
		else
		{
			header('Location:offer.php?msg=4');
			die();
		}	
}
    
if(isset($_REQUEST['deactive_offer']))
{
    	if($offerobj->deactive())
		{
			header('Location:offer.php?msg=5');
			die();  
		}
		else
		{
			header('Location:offer.php?msg=4');
			die();  
			
		}	
}

if(isset($_REQUEST['delete_offer']))
{
    	if($offerobj->delete())
		{
			header('Location:offer.php?msg=7');
			die();  
		}
		else
		{
			header('Location:offer.php?msg=4');
			die();  
			
		}	
}

if(isset($_REQUEST['active_offer']))
{
    	if($offerobj->activate())
		{
			header('Location:offer.php?msg=6');
			die();  
		}
		else
		{
			header('Location:offer.php?msg=4');
			die();  
			
		}	
}
if (isset($_REQUEST['edit']))
{
	$offer_editid = inputString(trim($_REQUEST['edit']));
	if($offer_editid !='' && is_numeric($offer_editid))
	{
		$result_edit = $offerobj->offerdetailbyid($offer_editid);
	}
	else
	{
		header('location:offer.php?add=true&msg=4');
		die();
	}	
}
$result = $offerobj->offerlist();
$venuedata = $venueobj->venueidnameforofferlist();
?>