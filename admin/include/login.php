<?php
require_once ("system/config.php");
if(isset($_REQUEST['login'])){


	
	$email = inputString($_REQUEST['email']);


         
	$password = inputString($_REQUEST['password']);
        
	$captchacod = $_REQUEST['captcha_code'];
	
	if($email==""){
		header("Location: login.php?msg=4");
		die();
	}elseif($password==""){
		header("Location: login.php?msg=5");
		die();
	}elseif(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $captchacod) != 0){
		header("Location: login.php?msg=4");
		die();
	}else{	

	
		$userobj = (object) new user();

	    $access_token = uniqid();
	 $result = $userobj->login($email,$password,$access_token);

        
		if(isset($result['error']))
        {
        	if(isset($result['error_suspend']))
			{
				header("Location: login.php?msg=13");
            	die();
			}
			else {
				 header("Location: login.php?msg=3");
            	die();	
			}            
           
        }
        else{
        	
		
			if(isset($_REQUEST['agree']))
			{
				setcookie('whozoutuser_email', $email, time() + 86400);
				setcookie('whozoutuser_password',base64_encode($password), time() + 86400);
			}


			        	
		    $_SESSION['user'] = $result['user'];
			$_SESSION['user_permission'] = $userobj->getpermissionuserid($result['user']['user_id']);
		
			header("Location: index.php");
            die();
        }
	}
}

if(isset($_REQUEST['add_user']))
{
		$userobj = (object) new user();
		if(!$userobj->emailcheck($_REQUEST['email']))
		{
			header('location:signup.php?msg=1');
			die();
		}
		
    	$firstname = inputString($_REQUEST['firstname']);
		$lastname  = inputString($_REQUEST['lastname']);
		$email     = inputString($_REQUEST['email']);
		$contact_no =inputString($_REQUEST['contact_no']);
		$password = pass_encrypt($_REQUEST['password']);
		$imagefilename = '';
		
		
		if($_REQUEST['single_image'] !='')
		{
				$imagefilename = $_REQUEST['single_image'];
				copy("tempimage/$imagefilename", "uploads/".$imagefilename);
				copy("tempimage/crop/".$imagefilename,"uploads/crop/$imagefilename");
				
				unlink("tempimage/$imagefilename");
				unlink("tempimage/crop/$imagefilename");
		}
		
		/*
		if($_FILES['photo']['name'] !="")
		{
					
			$filename  = basename($_FILES['photo']['name']);
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$imagefilename = uniqid().'.'.$extension;
			if(move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$imagefilename))
			{
				copy("uploads/".$imagefilename,"uploads/crop/$imagefilename");
			}
		}*/
		
		$response = $userobj->manageradd($firstname,$lastname,$email,$contact_no,$password,$imagefilename,2);
		if($response['STATUS'])
		{
				header('Location: login.php?msg=2');
				die();
		}
		else
		{
				header('location:signup.php?msg=3');
				die();
		}	
		
				
}
if(isset($_REQUEST['forgot_password'])){
	
	$email = inputString($_REQUEST['email_forgot']);
	if($email==""){
		header("Location: login.php?msg=4");
		die();
	}else{
		$userobj = (object) new user();
	    $result = $userobj->forgotPassword($email);
        if($result['STATUS']==1)
		{
			header("Location: login.php?msg=11");
			die();
		}
		else {
			
			header("Location: login.php?msg=12");
			die();
		}
	}
}
if(isset($_REQUEST['token'])){
	
		if(trim($_REQUEST['token']))
		{
			$userobj = (object) new user();
		    $result = $userobj->userdetailbytoken($_REQUEST['token']);
			if(count($result)>0){
				$edit_user_details = $result;
			}	
			else
			{
				header("Location: login.php?msg=7");
				die();			
			}	
		}
		else
		{
				header("Location: login.php?msg=7");
				die();			
		}		

}
if(isset($_REQUEST['password_submit'])){
	
	if($_POST['new_password'] == $_POST['conf_password'])
	{
			$userdata = array();	
			$userdata['user_id'] = $_POST['user_id'];
			$userdata['password'] = base64_encode($_POST['new_password']);	
			$userobj = (object) new user();
		   if($userobj->changePassword($userdata['user_id'],$userdata['password']))
		   {
		   		header("Location: login.php?msg=10");
				die();
		   }
		   else
		   {
		   		header("Location: login.php?msg=3");
				die();
		   }
	}
}
if(isset($_REQUEST['action']))
{
	if($_REQUEST['action'] == "check_email")
	{
		$userobj = (object) new user();
		if(!$userobj->emailcheck($_REQUEST['email']))
		{
			echo "0";
		}
		else
		{
			echo "1";
		}
		die;
	}
	
}


?>