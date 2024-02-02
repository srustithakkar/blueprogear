<?php define('BASEURL','https://www.blueprogear.com');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Blue Protective Gear - Products</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/plugin.css" rel="stylesheet">
<!--<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,900|Tinos:400,700" rel="stylesheet">-->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">
<link href="css/vendor.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="loadingpage">
  <div class="loader">
    <p class="loader__label"><img src="images/logo.png" width="691" height="250"></p>
    <div class="loader__figure"></div>
  </div>
</div>
<header class="navbar-fixed-top">
  <div class="mainnav">
    <div class="container hasrelative">
      <div class="navbar-header"> <a class="navbar-brand" href="index.php#home"><img src="images/logo.png" width="691" height="250" class="img-responsive"></a> </div>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainmenu" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <nav class="navbar menu menu--francisco">
        <div id="mainmenu" class="collapse navbar-collapse">
           <ul class="nav navbar-nav menu__list">
            <li class="menu__item active"><a href="<?=BASEURL?>/index.php#home" class="menu__link">Home</a></li>
            <li class="menu__item"><a href="<?=BASEURL?>/index.php#whoweare" class="menu__link">who we are</a></li>
            <li class="menu__item"><a href="<?=BASEURL?>/index.php#industries" class="menu__link">industries</a></li>
            <li class="menu__item"><a href="<?=BASEURL?>/index.php#products" class="menu__link">products</a></li>
            <li class="menu__item"><a href="<?=BASEURL?>/index.php#norms" class="menu__link">norms</a></li>
            <li class="menu__item"><a href="<?=BASEURL?>/index.php#whyus" class="menu__link">why us</a></li>
            <li class="menu__item"><a href="<?=BASEURL?>/index.php#reachus11" class="menu__link">Reach us</a></li>
            
          </ul>
        </div>
      </nav>
    </div>
  </div>
</header>
		  <?php
include("master/config.php");
$con= connect();?>
<div class="pagecontent">
  <section class="productpage orange">
    <div class="data-middle">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <div class="leftnav"><a href="#" class="nav-tabs-dropdown btn btn-block">Tabs</a>
              <ul id="nav-tabs-wrapper" class="nav productslistnav">
			  <?php


$query="select * from mst_product where is_delete='0'";
$run=mysqli_query($con,$query);
//$result=mysqli_fetch_array($run);
$active='active';
 while($result=mysqli_fetch_array($run))
    {$id=$result['id'];
		$photo=$result['photo'];
		$title=$result['title'];
 if(isset($_GET['id'])){
	

if($_GET['id']==$result['id']){
	
	 echo  "<li class='active'><a href='#p$id' data-toggle='tab'><span><img src='admin/uploads/crop/$photo' width='300' height='300'> <small>$title</small></span></a></li>";
}else{
	
	 echo  "<li ><a href='#p$id' data-toggle='tab'><span><img src='admin/uploads/crop/$photo' width='300' height='300'> <small>$title</small></span></a></li>";
}
}	

else{
	
	 echo  "<li class='$active'><a href='#p$id' data-toggle='tab'><span><img src='admin/uploads/crop/$photo' width='300' height='300'> <small>$title</small></span></a></li>";
	}
	$active='';}?>
			
                      </ul>
            </div>
          </div>
		  
		  <?php


$query="select * from mst_product where is_delete='0'";
$run=mysqli_query($con,$query);
//$result=mysqli_fetch_array($run);

?>
   
          <div class="col-md-10">
            <div class="tab-content">
			<?php
			
			// for ($i = 0; $i < count($result); $i++)
				$active='active';
    while($result=mysqli_fetch_array($run))
    {
        ?>
              <div role="tabpanel" class="tab-pane fade in <?php echo isset($_GET['id'])?$_GET['id']==$result['id']?  'active':'':$active;?>" id="p<?php echo $result['id'];?>">
                <div class="row">
                  <div class="col-sm-5"><img src="admin/uploads/crop/<?php echo $result['photo']?>" width="1042" height="1170" class="img-responsive productimg"></div>
                  <div class="col-sm-7">
                    <div class="productdetails">
                      <h1><?php echo $result['title']; ?></h1>
                      <p><?php echo $result['description']; ?></p>
                      <div class="actionbtn">
                        <div class="row">
                          <div class="col-sm-6"><a href="<?=BASEURL?>/index.php#reachus11" class="btn btn-block"><i class="fa fa-shirtsinbulk"></i> Request <span>a Sample</span></a></div>
                          <div class="col-sm-6"><a href="<?=BASEURL?>/index.php#reachus11" class="btn btn-block"><i class="fa fa-file-text-o" aria-hidden="true"></i> Get <span>an estimate</span></a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	<?php $active=''; } ?>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="copyright blue">
    <div class="container">
      <div class="row">
        <div class="col-md-5 col-sm-6"><span>© 2016-17, blueprogear.com. All Rights Reserved.</span></div>
        <div class="col-md-4 col-sm-6">
          <div class="flinks"><a href="#">Disclaimer</a> | <a href="#">Terms and conditions</a></div>
        </div>
        <div class="col-md-3 col-sm-12">
          <div class="socials">
            <ul>
              <li><a class="fb" href="https://facebook.com/blueprogear" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a class="tw" href="https://twitter.com/blueprogear" target="_blank"><i class="fa fa-twitter"></i></a></li>
              <li><a class="fb" href="https://www.linkedin.com/company/blue-protective" target="_blank"><i class="fa fa-linkedin"></i></a></li>
              <li><a class="gp" href="https://plus.google.com/+BlueProtectiveGearAhmedabad" target="_blank"> <i class="fa fa-google-plus"></i></a></li>
              <li><a class="pt" href="https://www.pinterest.com/blueprotectiveg/" target="_blank"> <i class="fa fa-pinterest"></i></a></li>
              <li><a class="gp" href="https://www.instagram.com/blueprogear" target="_blank"> <i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/app.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/57c96c09e90bf561a3529203/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
