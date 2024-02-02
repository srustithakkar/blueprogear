<?php
require_once("system/config.php");
if(isset($_SESSION['user']))
{
	header("Location: index.php");
	die();
}

 
include("include/login.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Blue Protective Gear - Admin Panel</title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<link rel="stylesheet" href="template/css/bootstrap.css" />		
		<link rel="stylesheet" href="template/css/main.css" />
		<link rel="stylesheet" href="template/css/main2.css" />
		<link rel="shortcut icon" href="template/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="template/images/favicon.ico" type="image/x-icon">
	</head>
	 
	 <body>
		 
		 <div id="login_min">
		 	<div class="lgn_hdr">
		 		<a href="login.php"><img src="../images/logo.png"/></a>
			</div>
		 	 <div class="lgn_contnt">
		 	 	  <div class="curv">
		 	 		   <div class="profile_img"> <img src="template/images/profile_icon.png" /> </div>
		 	 		 </div>
		 	           <div class="login_logo">
		 	 	 	    	Login Now!
		 	 	 	    </div>
		 	 	 	    <?php if(isset($_REQUEST['msg'])){
                        switch($_REQUEST['msg']){   
                        case "1":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Please change your email id it already exits";
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
                                $msg = "Session timeout!";
                                break;
                        
                        case "7":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Token mismatch!";
                                break;
						case "8":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Please try again or check your email id!";
                                break;	
                         case "9":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Please check your token!";
                                break;	
						case "10":
                                $alert_type = "alert alert-success alert-dismissable";
                                $msg = "Password change successfully!";
                                break;	 
						case "11":
                                $alert_type = "alert alert-success alert-dismissable";
                                $msg = "Please check your email for password reset link!";
                                break;
								
						case "12":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Entered email address is not registered with us";
                                break;
                            case "13":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Your account is suspended.";
                                break;     		
						 case "14":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Your captcha code is not match.";
                                break; 						  		       	
								
                        }
                    ?>
                    
                    <div class="<?php echo  $alert_type; ?>" style="margin: 0px auto; width: 92%;">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $msg; ?>
                    </div>
                    <?php } ?>
                    
                    <?php 
                     				$emailid = '';
									$passwordid = '';
									if(isset($_COOKIE['whozoutuser_email']))
									{
										$emailid = $_COOKIE['whozoutuser_email'];
									}
									if(isset($_COOKIE['whozoutuser_password']))
									{
										$passwordid = base64_decode($_COOKIE['whozoutuser_password']);
									}
						?>			
		 	 	      <div class="lgn_bottom">
		 	 	       <form method="post" style="margin-top: 10px;" id="login-form" action="" role="form">
							<label>
							   <input class="lgn_control us_icon" placeholder="Email Address" name="email" id="email" type="email" autofocus="" value="<?php echo $emailid;?>">
						   </label> 
						   <label class="pserror"> 
							  <input class="lgn_control pass_icon" placeholder="Password" name="password" id="password" type="password" value="<?php echo $passwordid;?>" onkeypress="return nospaces(event)">
						  </label> 
						  
						  <label class="captcha_img"> 
						  	 <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg' >
						  	 <a href='javascript: refreshCaptcha();' class="refresh"></a>
  						  </label>
  						  
  						  <label> 
  						  <input id="captcha_code" class="lgn_control" name="captcha_code" type="text" placeholder="Captcha Code">
  						  </label>
						  
						 
						 	 
									 <span class="rembr-check">
						   	   	    	<input id="lctn1" class="css-checkbox" type="checkbox" name="agree" value="1">
										<label class="css-label" for="lctn1">Remember Me</label> 
									</span>	
							  
						   <span class="control_btn lgnt">
							  <input class="login_btn" name="login" type="submit" value="Login">
						   </span>
						   
						    
						</form> 
						
						
						
						 <div class="forgot">
						 		 
						 			
						   	   <span class="po-relative">
						   	   	  
									   
									<span class="for_pass">Forgot Password?</span> 
						   	   </span>
						   	    
						 <form method="post" style="margin-top: 10px;" id="forgot-form" action="" >  	   
						   	   <span class="forgot_slide">
						   	   	   <p>Please share your email id to receive the link to reset your Password</p>
						   	   	   <label class="eml_frgt"> 
						   	   	 
							        <input class="lgn_control mail_icon" type="text" placeholder="Email Address" name="email_forgot" id="email_forgot" value="">
						           </label> 
						           
						 			  <label> <input class="send_email" type="submit" value="Send Email" name="forgot_password"> </label>
						            
						   	   </span>
						  </form>
						   	   
						   </div>
						    
 					 
		 	 	   </div>
		 	   </div>
		 	</div>
	<script src="template/js/jquery-1.11.0.min.js"></script>
	<script src="template/js/bootstrap.min.js"></script>
	<script src="template/js/jquery.validate.min.js"></script>  
	<script type="text/javascript">
	
	function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	$("#captcha_code").val('');
}
    
			$(document).ready(function() { 
				$("span.for_pass").click(function(){
				$("span.forgot_slide").slideDown( "slow" );
				$("span.forgot_slide").addClass("slide_down");
				$("input#email_forgot").focus();
			    });
			    
			  /*  $("input.send_email").click(function(){
			    $("span.forgot_slide").slideUp( "slow" );
				$("span.forgot_slide").removeClass("slide_down");
			    });
			   */ 
			    
			    
			    jQuery.validator.addMethod("checkcaptcha", function(val, elem) {
		var result = false;
			$.ajax({
				url:'captcha.php',
				type:'POST',
				data:'verify='+val,
				dataType: 'json',
				async: false, 
				success: function(data) {
					if(data=="1"){
						result = true;
					}
		      	}
		    });
		    return result;
		});
			    
			    $("#login-form").validate({
		           errorElement: "span",
		            errorClass: "error",
		            onclick: true,
		            onkeyup: false,
		            rules: {
		                email: {
		                    required: true,
		                    email: true
		                },
		                password: "required",
		                captcha_code:{
                			required: true,
                			checkcaptcha: true
               		},
		                
		            },
		            messages: {
		                email: {
		          			      required: 'Enter email address',
		 		                    email: 'Enter valid email address',
		                },
		 	             password: 'Enter password',
		 	             captcha_code: {
               		 	required: 'Pleser enter captcha code',
                			checkcaptcha: "Please enter valid captcha code"
                		}
		            }
		        });
		        
		        
		        $("#forgot-form").validate({
		           errorElement: "span",
		            errorClass: "error",
		            onclick: true,
		            rules: {
		                email_forgot: {
		                    required: true,
		                    email: true
		                }
		            },
		            messages: {
		                email_forgot: {
		          			      required: 'Enter email address',
		 		                  email: 'Enter valid email address',
		                }
		 	        }
		        });
			    
			});
	</script>
	
	<script type="text/javascript">  
	    function nospaces(evt)  
	    {  
	        var charCode = (evt.which) ? evt.which : event.keyCode  
	        if(charCode == 32)  
	            return false;  
	        return true;  
	    }  
	</script>
	

	
	
	
	
	   
</body>
</html>
