<?php 
if(isset($_REQUEST['forgot-password'])){
             
         $email = $_REQUEST['email'];
    
         $sql = "SELECT * FROM `irec_user` WHERE `email_address`='".$email."' AND `user_type`='admin';";
         $result_user = $DAO->select($sql);
         
         if($result_user != 0)
         {
             if($result_user[0]['password']!=""){
             	
				$token=uniqid();
				 
				$query = "UPDATE 
							`irec_user` 
                          SET 
                            `activation_token`='".$token."' 
                          WHERE 
                            `email_address`='".$result_user[0]['email_address']."'";
				$result = $DAO->query($query);
				
				$to = $email;
				$subject = 'Reset Password';
				
				$message = '<br/>Hello '.$result_user[0]['first_name'].',<br/><br/>
				Someone has requested for new password, please <a href="'.WEBSERVICE_PATH.'changepassword.php?token='.$token.'"><b>click here</b></a> to reset your password.<br><br>
				If this was not you, please ignore the email.<br/><br/>';
				$message = $email_header.$message.$email_footer;
				
				$headers = 'From: '.ADMIN_EMAIL . "\r\n" .
				     'Reply-To: '.ADMIN_EMAIL . "\r\n" .
				     'X-Mailer: PHP/' . phpversion();
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$send_mail = mail($to, $subject, $message, $headers);
				
                //$result = send_forgot_password_email($result_user);
                header("location: index.php?msg=1");
				die();
             }else{
                 header("location: forgot-password.php?msg=2&mail=$email");
				 die();
            }
         }else{
             header("location: forgot-password.php?msg=3");
			 die();
         }
 }
?>
