<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
	<link rel="stylesheet" href="template/css/bootstrap.css" />		
	<link rel="stylesheet" href="template/css/main.css" />
	<link rel="stylesheet" href="template/css/main2.css" />
    <link href="template/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="template/css/jquery-ui.css">
	<link rel="shortcut icon" href="template/images/favicon.ico" type="image/x-icon">

 

	<style>
		.js-dsbl a {
		    background: none repeat scroll 0 0 #808080;
		    border: 1px solid #FFFFFF;
		    border-radius: 4px;
		    margin: 0 8px;
		    padding: 3px 8px;
		}
	</style>
	<noscript>
	<div class="alert alert-danger alert-dismissable js-dsbl">
		<!--<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>-->
		Javascript is disabled in your web browser, some features may not work, <a href="http://www.enable-javascript.com/" target="_blank"> Click here </a> to get instructions how to enable JavaScript in your web browser
	</div>
	</noscript>
</head>
<body>
	
	<header>
	<a href="index.php"><div class="pull-left logo_main"></div></a>
				<div class="pull-right user_log">
					<span class="us_nm">

						<?php
						
						
						global $DAO;
						$sql = "SELECT firstname,lastname,photo FROM `user` where user_id=".$_SESSION['user']['user_id'];
						$resultp_detail = $DAO->select($sql);
						
						
						$filecheck ='';
						if($resultp_detail[0]['photo'])
						{
							$filecheck = "uploads/crop/".$resultp_detail[0]['photo'];
						}					
						?>
						
						<?php if($filecheck != ""){	?>
						<img src="<?php echo $filecheck;?>" width="100" height="100" />
						<?php } else{ ?>
						<img src="template/images/user1.png" width="100" height="100" />
						<?php }?>
						
						<h4><?php echo ucfirst(stripslashes($resultp_detail[0]['firstname']));?></h4>
						<p><?php echo ucfirst($resultp_detail[0]['lastname']);?></p>
					</span>
					<a href="logout.php"><span class="log_out">Logout</span></a>
				</div>
				<div class="clr"></div>
	</header>
<style>
.asterisk {
	color : red;
}

</style>
<article>
	<div class="col-md-2 side_menu">
	        <?php include 'left-menu.php';?> 
	</div>
	<div class="col-md-10 content_main">