<?php

define('EMAIL_BG_COLOR','#000');
define('EMAIL_FONT_COLOR','#000');
define('EMAIL_LOGO_URL',ROOT_PATH.'template/images/logo_login.png');
define('EMAIL_TEAM',SITE_NAME.' Team');

$email_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>'.SITE_NAME.'</title>
</head>
<body>
	<table style="border:none; width:100%; background-color:'.EMAIL_BG_COLOR.';">
	    <tr>
			<td>
				<a href="'.ROOT_PATH.'" style="float:left; margin:15px 10px;"><img src="'.EMAIL_LOGO_URL.'" width="300" /></a>
			</td>
	    </tr>
	</table>
	<table style="border:none; width:100%; padding:10px 20px;">
		<tr>
			<td style="word-wrap: break-word;word-break:break-all;">';

$email_footer = 'Sincerely,<br/>Your '.EMAIL_TEAM.'<br/><br/>
				</td>
			<tr>
		</table>
		<table style="border:none; width:100%; background-color:'.EMAIL_BG_COLOR.';">
			<tr>
				<td colspan="2">
				</td>
			</tr>
		</table>
	</body>
</html>';


/* Wel-come user email tenmplate */
$welcome_email = '<br/>Hello [#USER_NAME#],<br/><br/>
				Thanks for registration with '.SITE_NAME.'.<br/><br/>
				<b>Below are your account details  :: </b><br/><br/>
				Email address :: [#EMAIL#]<br/><br/>';
$welcome_email = $email_header.$welcome_email.$email_footer;

/* Forgot Password Email Template */
$forgot_password_email = '<br/>Hello [#USER_NAME#],<br/><br/>
				Forgot your password? No worries. 
				Please <a href="[#REST_LINK#]"><b>click here</b></a> to reset Your Password.<br/><br/>Your Email ID is: [#EMAIL#]<br/><br/>Thank you for Outing with BluePro.<br/><br/>';
$forgot_password_email = $email_header.$forgot_password_email.$email_footer;
				
				
/* Request to password */

$request_password_email = '<br/>Hello [#USER_NAME#],<br/><br/>
				Email : [#EMAIL#]<br/>
				Password : [#PASSWORD#]<br/><br/>
				If you want to change password then follow this <a href="[#REST_LINK#]"><b>link</b></a>.<br/><br/>Thank you for Outing with BluePro.<br/><br/>';
$request_password_email = $email_header.$request_password_email.$email_footer;				
				
/* Update Password Email Template */
$update_password_email = '<br/>Hello [#USER_NAME#],<br/><br/>
				Your '.SITE_NAME.' password has been updated.<br/>
				If this was not you, please ignore the email, otherwise <a href="[#REST_LINK#]"><b>click here</b></a> to change password.<br/><br/>';
$update_password_email = $email_header.$update_password_email.$email_footer;

$notification_email = '<br/>Hello <br/><br/>[#DESCRIPTION#]<br/><br/>';
$notification_email = $email_header.$notification_email.$email_footer;

?>