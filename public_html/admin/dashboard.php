<?php
include("include/ethinicity.php");
if($_SESSION['user']['user_type']==5 || $_SESSION['user']['user_type']==2)
{
	header("Location: permissionerror.php");
    die();
}	
include("template/header.php");
$add_button_text = "Add Venue";
$edit_button_text = "Update Venue";
?>
<link rel="stylesheet" href="template/css/imagestyle.css" />
<link rel="stylesheet" type="text/css" href="template/css/imgareaselect-animated.css" />
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<div class="add_goal">
		<div class="ad_lft">
			<span class="pg_titl"><h1>Dashboard</h1></span>
		</div>
	</div>
	<style>
		.user-details-in table tr td:nth-child(2) {
			text-align: right;
		}
	</style>
	<?php
		$dashboard = (object) new dashboard();
		$result = $dashboard->usermanager();
		$totalcheckout = $dashboard->totalcheckout();
		$result_venue = $dashboard->venuelist();
	?>
	
	
	<section class="content_in">
		<div class="row-cntn">
		<div class="col-md-4">
			<div class="w-data user">
				
				<?php if($result[0]['users']>1){ ?>
				<div><span id="tuser"><?php echo $result[0]['users']?></span>Total Products</div>
				<?php }else{ ?>
				<div><span id="tuser"><?php echo $result[0]['users']?></span>Total Products</div>	
				<?php } ?>	
				<span class="d-img dimg1"></span>
			</div>
		</div>
		
		
		<div class="col-md-4">
			<div class="w-data vanue">
				<?php if($result_venue[0]['venue']>1){ ?>
				<div><span id="tvenue"><?php echo $result_venue[0]['venue']?></span>Total Certification</div>
				<?php }else{ ?>
				<div><span id="tvenue"><?php echo $result_venue[0]['venue']?></span>Total Certification</div>
				<?php } ?>	
				<span class="d-img dimg1"></span>
			</div>
		</div>
	</div>
	</section>

<?php include("template/footer.php"); ?>

 

<script>
$(document).ready(function() {
			var usertotal = <?php echo $result[0]['users'];?>;
			var tuser = $("#tvenue").html();
			var tcheckout = $("#tcheckout").html();
			getPerc(usertotal,$(".w-data.user div"),20);
			getPerc(tuser,$(".w-data.vanue div"),20);
            getPerc(tcheckout,$(".w-data.chk-ins div"),20);
         });
	
</script>

<script src="template/js/jquery-1.11.0.min.js"></script>
<script src="template/js/bootstrap.min.js"></script>
<script src="template/js/igs.js"></script>
