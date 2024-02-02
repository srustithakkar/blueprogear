<?php
require_once("system/config.php");
if(isset($_SESSION['user']))
{
	header("Location: index.php");
	die();
}
if(!$_GET['token'])
{
	header("Location: login.php");
	die();
	
}
include("include/login.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Login Page -<?php echo SITE_NAME; ?></title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<link rel="stylesheet" href="template/css/bootstrap.css" />		
		<link rel="stylesheet" href="template/css/main.css" />
		<link rel="stylesheet" href="template/css/main2.css" />
	</head>
	 
	 <body>
		 
		 <div id="login_min">
		 	<div class="lgn_hdr">
		 		<img src="template/images/logo_login.png"/>
			</div>
		 	 <div class="lgn_contnt">
		 	 	  <div class="curv">
		 	 		   <div class="profile_img"> <img src="template/images/profile_icon.png" /> </div>
		 	 		 </div>
		 	           <div class="login_logo">
		 	 	 	    	Change Password!
		 	 	 	    </div>
		 	 	 	    <?php if(isset($_REQUEST['msg'])){
                        switch($_REQUEST['msg']){   
                        case "1":
                                $alert_type = "alert alert-success alert-dismissable";
                                $msg = "Please check your email for password reset link";
                                break;
                        case "2":
                                 $alert_type = "alert alert-success alert-dismissable";
                                 $msg = "Congratulations you have successfully registered.";
                                 break;
                        
                        case "3":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Incorrect credentials, try again.";
                                break;
                        
                        case "4":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Wrong email.";
                                break;
                        
                        case "5":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Wrong password.";
                                break;
                        
                        case "6":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Session Timeout!";
                                break;
                        
                        case "7":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Token mismatch!";
                                break;
						case "8":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Please try again or check your email id!";
                                break;		
								
                        }
                    ?>
                    
                    <div class="<?php echo  $alert_type; ?>" style="margin: 0px auto; width: 92%;">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $msg; ?>
                    </div>
                    <?php } ?>
                    
		 	 	      <div class="lgn_bottom">

                	<form id="change-password-form" class="validate_form" action="" method="post" autocomplete="off">
                		<input type="hidden" name="user_id" id="user_id" value="<?php echo $edit_user_details[0]['user_id']; ?>" />
                		
                		<label>
							   <input type="password" name="new_password" id="new_password" class="lgn_control pass_icon" value="" placeholder="New Password" autofocus="" >
					   </label> 
					   <label> 
					     	<input type="password" name="conf_password" id="conf_password"  class="lgn_control pass_icon" value="" autofocus="" placeholder="Confirm Password">
							  
					  </label> 
					  <span class="bt_line"></span>
					  <span class="control_btn">
							  <input type="submit" value="Submit" class="signup_btn" name="password_submit">  
						   </span>
                		
                	</form>
               		 
		 	 	   </div>
		 	   </div>
		 	</div>
	<script src="template/js/jquery-1.11.0.min.js"></script>
	<script src="template/js/bootstrap.min.js"></script>
	<script src="template/js/jquery.validate.min.js"></script>  


<script type="text/javascript">
$(document).ready(function() {
	
	
	
	
    $("#change-password-form").validate({
    	onkeyup: false,
	    rules: {
	        new_password: {
	            required: true,
	            minlength:6,
	            maxlength:20,
	        },
	        conf_password: {
	            required: true,
	            minlength:6,
	            maxlength:20,
	            equalTo: "#new_password",
	        }
	    },
	    messages: {
	        new_password: {
	            required: "Please enter new password",
	            minlength:"New password must consist of 6-20 characters",
	            maxlength:"New password must consist of 6-20 characters",
	        },
	        conf_password: {
	            required: "Please enter confirm password",
	            minlength:"Confirm password must consist of 6-20 characters",
	            maxlength:"Confirm password must consist of 6-20 characters",
	            equalTo: "New password and confirm password must be same",
	        }
	    }
	});
});
</script>