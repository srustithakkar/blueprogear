<?php
require_once("system/config.php");

if(count($_SESSION['user'])>0){
    header("Location: irec.php");
    die();
}
include("include/forgot-password.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?php echo SITE_NAME; ?></title>
    <!-- Core CSS - Include with every page -->
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="template/sb-admin.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="template/images/logo.png">
</head>

<body>
    <body oncopy="return false;" onpaste="return false;" oncut="return false;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <!-- <h3 class="panel-title">Please Sign In</h3> -->
                        <img src="template/images/logo.png" width="50" />
                        <h3 class="panel-title">Enter Admin Email Address</h3>
                    </div>
                    <?php if(isset($_REQUEST['msg'])){
                        switch($_REQUEST['msg']){   
                        case "2":
                                $alert_type = "alert alert-danger alert-dismissable";
                                $msg = "Admin with '".$_REQUEST['mail']."' email address is not registered with us";
                                break;                         
                        // case "3":
                                // $alert_type = "alert alert-danger alert-dismissable";
                                // $msg = "Wrong email or passowrd.";
                                // break;
                        }
                    ?>
                    
                    <div class="<?php echo  $alert_type; ?>">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $msg; ?>
                    </div>
                    <?php } ?>
                    <div class="panel-body">
                        <form method="post" style="margin-top: 8px;" id="forgot-password-form" action="" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" id="email" type="email" autofocus>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input class="btn btn-lg btn-success btn-block" name="forgot-password" type="submit" value="Get Account Details">
                            </fieldset>
                        </form>                        
                        <div style="margin-left: 140px; padding-top: 10px;">
                            <a href="index.php" class="forgot-pass">Login</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Core Scripts - Include with every page -->
    <script src="template/js/jquery-1.10.2.js"></script>
    <script src="template/js/bootstrap.min.js"></script>
    <script src="template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="template/js/sb-admin.js"></script>
    <script src="template/js/jquery.validate.min.js"></script>
    
    <script type="text/javascript">
    
    $(document).ready(function(){
        $("#forgot-password-form").validate({
            errorElement: "span",
            errorClass: "error",
            onclick: true,
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: 'Enter email address',
                    email: 'Enter valid email address',
                }
            }
        });
    });
    
    </script>
</body>
</html>
