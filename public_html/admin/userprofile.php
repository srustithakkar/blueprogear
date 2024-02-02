<?php
include("include/userprofile.php");
include("template/header.php");
$edit_button_text = "Update Account";
?>
<link rel="stylesheet" type="text/css" href="template/css/imgareaselect-animated.css" />
<style>
	#change-password-form label.error {
	margin-left: 240px;
}  
</style>
<div class="add_goal">
	<div class="ad_lft">
		<span class="pg_titl"><h1>My Account</h1></span>
	</div>
	<div class="clr"></div>

   <?php if(isset($_REQUEST['msg'])){
            switch($_REQUEST['msg']){   
            case "1":
                    $alert_type = "alert alert-danger alert-dismissable";
                    $msg = "Email already exist ";
                    break;
            case "2":
                    $alert_type = "alert alert-success alert-dismissable";
                    $msg = "Manager added successfully";
                    break;
            case "3":
                    $alert_type = "alert alert-success alert-dismissable";
                    $msg = "Account updated successfully";
                    break;
            case "4":
                    $alert_type = "alert alert-danger alert-dismissable";
                    $msg = "Something went wrong , please try again.";
                    break;
            case "5":
                    $alert_type = "alert alert-success alert-dismissable";
                    $msg = "Updated successfully ";
                    break;
            case "6":
                    $alert_type = "alert alert-danger alert-dismissable";
                    $msg = "Profile picture not uploaded, please try again.";
                    break;
			case "7":
                    $alert_type = "alert alert-success alert-dismissable";
                    $msg = "Password updated successfully";
                    break;
			case "8":
                    $alert_type = "alert alert-success alert-dismissable";
                    $msg = "User deleted successfully";
                    break;
            }
	?>
    <div class="<?php echo  $alert_type; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $msg; ?>
    </div>
    <?php 
	} 
	?>      
</div>
<section class="content_in">
<ul class="nav nav-tabs no-tabs" id="myTab">
	<li class="active"><a data-toggle="tab" href="#dealinfo">Profile Information</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div id="dealinfo" class="tab-pane action_inner1 active">
  	<ul>
  		 <form action="" id="user_form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $result_edit[0]['user_id']; ?>" />
                 <input type="hidden" name="imagename" value="<?php echo $result_edit[0]['photo']; ?>" />
              
       <li class="pr_pickcr">
	  		<p>Profile Picture:</p>
	  		
				<span class="img_upld single_image">
					
				    <?php if($result_edit[0]['photo'] != ""){	?>
						<img style="width: 100px; height: 100px;" src="uploads/crop/<?php echo $result_edit[0]['photo']; ?>"/>
					<?php } else{ ?>
						<img src="template/images/user1.png" width="100" height="100" />
					<?php }?>
				</span>
				<button class="sfile" onclick="return false;">Upload Photo</button>
				<input type="file" name="images" id="images" style="display: none;" accept="image/*"/>		
				<input type="hidden" name="single_image" id="single_image" value="">	
	  			<input type="hidden" name="single_x" id="single_x"/>
	  			<input type="hidden" name="single_y" id="single_y"/>
	  			<input type="hidden" name="single_w" id="single_w"/>
	  			<input type="hidden" name="single_h" id="single_h"/>
		</li>
		
  		<li>
  		<p>First Name:<span class="asterisk">&nbsp;*</span></p>
  		 <input type="text" maxlength="50" name="firstname" id="firstname" value="<?php if(isset($result_edit)){ echo $result_edit[0]['firstname']; } ?>" />
       </li>
  		
  		<li>
  		 <p>Last Name:<span class="asterisk">&nbsp;*</span></p>
  		 	<input type="text" maxlength="50" name="lastname" id="lastname" value="<?php if(isset($result_edit)){ echo $result_edit[0]['lastname']; } ?>" />
  		</li>
  		<li>
  		 <p>Email:</p>
  		 
  		 	<input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($result_edit)){ echo $result_edit[0]['email']; } ?>" readonly="readonly" />
   
        </li>
  		
  		<!--<li>
  		 <p>DOB<span class="asterisk">&nbsp;*</span></p>
  		  	<input type="text" readonly="readonly" name="dob" id="dob" readonly="readonly" 
  		  			value="<?php if(isset($result_edit)){
						 		 echo date('m-d-Y',strtotime($result_edit[0]['dob'])); 
						   } 
						   ?>" />
  		</li>
  		
  		
  		<li>
  		 <p>Gender</p>
  		  <div class="select_main">
  			   <select class="drp_down" name="gender" id="gender" >
                    <option  <?php if(isset($result_edit)){ echo $result_edit[0]['gender'] == 1 ? "selected" : ''; } ?> value="1">Male</option>
					<option <?php  if(isset($result_edit)){ echo $result_edit[0]['gender'] == 2 ? "selected" : ''; } ?> value="2">Female</option>
			   </select>
  		   </div>
  		</li>-->
  		<li>
  		 <p>Contact No:<span class="asterisk">&nbsp;*</span></p>
  		   	   <span class="inpt_err">
  		   	    <input type="text" maxlength="15" name="contact_no" id="contact_no" value="<?php if(isset($result_edit)){ echo $result_edit[0]['contact_no']; } ?>" />
  		   	    </span>
  		</li>
  		<div class="sec_4">
  		<p></p>
  		  <button data-target="#myModal2" data-toggle="modal" type="button" class="next">Change Password</button> 
  		</div>
  		
  		<div class="sec_4">
  		<p></p>
  		<a href="index.php" class="next cancel" id="prev1">Cancel</a>
  		<input type="submit" class="next" name="update_user" value="<?php echo $edit_button_text; ?>" />	
  	    </div>
  		</form>
  	</ul>
  	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-body">
			<h2>Change Password </h2>
			<form action="" method="post" id="change-password-form" name="change-password-form" autocomplete="off">
			<ul>
				<li>
				    <p>Current Password</p>
			    	<input type="password" name="old_password" id="old_password">
				</li>
				<li>
				    <p>New Password</p>
			    	<input type="password" name="new_password" id="new_password">
				</li>
				<li>
				    <p>Re-enter New Password</p>
			    	<input type="password" name="conf_password" id="conf_password">
				</li>
			</ul>
		<div class="modal_footer"> 
		    <div class="sec_4">
				<p></p>
				<a data-dismiss="modal" class="next cancel" href="#">Cancel</a>
				<input type="submit" class="next" name="passwordchange" value="Submit"/>
			</div>
			</form>
		</div> 	
		</div>
		</div>
		</div>
		</div> 
  	
  	</div> 
</div>

</section>
    
    <?php include("template/footer.php"); ?>
    <script type="text/javascript">
    $('#myModal2').on('hide.bs.modal',function(){
  			 $("#old_password").val('');
  			 $("#new_password").val('');
  			 $("#conf_password").val('');
  			 $("#change-password-form label").remove();
  	});  
    
    $(document).ready(function() {
 	   
 	   
 	   $(".sfile").click(function(){
		 $("input[id='images']").click();
	});
	
 	   jQuery.validator.addMethod("checkPassword", function(val, elem) {
		var result = false;
		$.ajax({
			url:'userprofile.php',
			type:'POST',
			data:'action=check_userpass&password='+val,
			dataType: 'json',
			async: false, 
			success: function(data) {
				if(data['STATUS']=="1"){
					result = true;
				}
	      	}
	    });
	    return result;
	});
	
	jQuery.validator.addMethod("notEqual", function(value, element, param) {
		return this.optional(element) || value != $(param).val();
	});
	
	jQuery.validator.addMethod("specialChars", function( value, element ) {
        var re = /^[ A-Za-z'-]*$/
         var key = value;
	     if (!re.test(key)) {
           return false;
        }
       return true;
    	}, "");
	
	
	
    $("#change-password-form").validate({
    	onkeyup: false,
	    rules: {
	        old_password: {
	            required: true,
	            checkPassword: true,
	            // minlength:6,
	            // maxlength:20,
	        },
	        new_password: {
	            required: true,
	            minlength:6,
	            maxlength:20,
	            notEqual:'#old_password',
	        },
	        conf_password: {
	            required: true,
	            minlength:6,
	            maxlength:20,
	            equalTo: "#new_password",
	        }
	    },
	    messages: {
	        old_password: {
	            required: "Please enter current password",
	            // minlength:"Current password must consist of 6-20 characters",
	            // maxlength:"Current password must consist of 6-20 characters",
	            checkPassword: "Incorrect current password"
	        },
	        new_password: {
	            required: "Please enter new password",
	            minlength:"New password must consist of 6-20 characters",
	            maxlength:"New password must consist of 6-20 characters",
	            notEqual: "Old and New Password can not be same",
	        },
	        conf_password: {
	            required: "Please enter confirm password",
	            minlength:"Confirm password must consist of 6-20 characters",
	            maxlength:"Confirm password must consist of 6-20 characters",
	            equalTo: "New password and Re-enter new password must be same",
	        }
	    }
	});
 	   
 	   
 	   
        $("#user_form").validate({
 
            rules: {
                firstname: {
                	required: true,
                	specialChars:true,
                    maxlength:30,
                },
                lastname: {
                	required: true,
                	specialChars:true,
                    maxlength:30,
                },
                email: {
                	required: true,
                	email:true,
                },
                contact_no: {
                	required: true,
                	number: true,
                	minlength: 8,
	                maxlength: 13
                }
            },
            messages: {
                firstname: {
                	required: "Please enter first name",
                	specialChars: "Enter valid first name",
                	maxlength: "Only 30 characters allows"
                },
                lastname: {
                	required: "Please enter last name",
                	specialChars: "Enter valid last name",
                	maxlength: "Only 30 characters allows"
                },
                email: {
                	required: "Please enter email",
                	email: "Please enter valid email",
                },
                photo: {
                	<?php if(!isset($result_edit)){ ?>
                	required: "Please select profile picture",
                	<?php } ?>
                	accept:"Please select valid image file",
                	
                },
                contact_no: {
                	required: "Please enter contact no",
                	number: "Please enter valid contact no",
                	minlength: "Must consist of 8-14 characters",
	                maxlength: "Must consist of 8-14 characters"
                }
            }
        });
        
         $("#dob").datepicker({
            	changeYear: true,
            	changeMonth: true,
            	yearRange : '1950:2014',
            	dateFormat: 'mm-dd-yy'
            });
    });
    
    
    
    </script>
    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script type="text/javascript" src="template/js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="template/js/script.js"></script>

