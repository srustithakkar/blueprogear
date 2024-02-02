<?php
	session_start();
	if(isset($_POST['verify']))
	{
		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['verify']) != 0)
		{  
			//$msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.
			echo 0;
			exit;		
		}
		else
		{
			echo 1;
			exit; 		
			//$msg="<span style='color:green'>The Validation code has been matched.</span>";		
		}		
	}
	else
	{	
		include("./phptextClass.php");	
		/*create class object*/
		$phptextObj = new phptextClass();	
		/*phptext function to genrate image with text*/
		$phptextObj->phpcaptcha('#fff','#4F4F4F',120,40,10,25);
	}		
 ?>