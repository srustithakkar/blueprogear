<?php
include("include/user.php");
if($_SESSION['user']['user_type']==5 || $_SESSION['user']['user_type']==2)
{
	header("Location: permissionerror.php");
         	die();
}	
include("template/header.php");
$add_button_text = "Add User";
$edit_button_text = "Update User";
?>
	 <link rel="stylesheet" type="text/css" href="template/css/imgareaselect-animated.css" />
	 
<style>
	#user_form .select_er label.error {
			width: 58%;
	}
</style>	 
	 
	<div class="add_goal">
			<div class="ad_lft">
				  
				 <?php if(isset($_REQUEST['add'])){ ?>
                        <span class="pg_titl"><h1>Add User</h1></span>
                        <?php } else if(isset($_REQUEST['edit'])){?>
                        <span class="pg_titl"><h1>Update User</h1></span>
                        <?php } else {?>
                        	<span class="pg_titl"><h1>User</h1></span>
				 		<?php } ?>
			</div> 
			  <?php 
			  
			   if($_SESSION['user_permission']['user']['add']){
			  
			  if(!isset($_REQUEST['add']) && !isset($_REQUEST['edit'])){ ?>
				<div class="pull-right op_sn">
					<a href="user.php?add=true">
						<div class="add_btn">
							<span>+</span>
							<p>Add User</p>
						</div>
					</a>
				</div>
			<?php } } ?>	
	 
             <?php if(isset($_REQUEST['msg'])){
                switch($_REQUEST['msg']){   
                case "1":
                        $alert_type = "alert alert-danger alert-dismissable";
                        $msg = "Email already exist ";
                        break;
                case "2":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "User added successfully";
                        break;
                case "3":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "User profile updated successfully";
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
                        $msg = "Please enter email address.";
                        break;
				case "7":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Password updated successfully";
                        break;
				case "8":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "User deleted successfully";
                        break;
				case "11":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Account details has been sent successfully";
                        break;				
                }
             ?>
                            <div class="<?php echo  $alert_type; ?>">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <?php echo $msg; ?>
                            </div>
            <?php } ?>
           </div>
            
            <?php if(isset($_REQUEST['add']) || isset($_REQUEST['edit'])){ ?>
           <section class="content_in">
                
                <form action="" id="user_form" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php if(isset($_REQUEST['edit'])){ ?>
                    <input type="hidden" name="user_id" value="<?php echo $result_edit[0]['user_id']; ?>" />
                    <input type="hidden" name="imagename" value="<?php echo $result_edit[0]['photo']; ?>" />
                    <?php } ?>
                    <ul class="nav nav-tabs no-tabs" id="myTab">
  						<li class="active"><a data-toggle="tab" href="#">User Information</a></li>
  					</ul>
  					<div class="tab-content">
							<div id="dealinfo" class="tab-pane action_inner1 active">
                    			<ul>
                    				 
                    				<li class="pr_pickcr">
                    					<p>Profile Picture:</p>
                           			  	<span class="img_upld single_image">
											<?php if(isset($_REQUEST['edit'])){
												 if($result_edit[0]['photo'] == ""){ ?>
											<img src="template/images/user1.png" style="width: 100px; height: 100px;" />	 	
											<?php	 
												 } if($result_edit[0]['photo'] != ""){ ?>
											<img style="width: 100px; height: 100px;" src="uploads/crop/<?php echo $result_edit[0]['photo']; ?>" />	 	
											<?php }} else{ ?>
	                    	  				<img src="template/images/user1.png" style="width: 100px; height: 100px;" />
	                    	  				<?php } ?>
										</span>
										<button class="sfile" onclick="return false;">Upload Photo</button>
										<input type="file" name="images" id="images" style="display: none;" accept="image/*" />		
										<input type="hidden" name="single_image" id="single_image" value="">	
	  									<input type="hidden" name="single_x" id="single_x"/>
	  									<input type="hidden" name="single_y" id="single_y"/>
	  									<input type="hidden" name="single_w" id="single_w"/>
	  									<input type="hidden" name="single_h" id="single_h"/>
									  </li>
                           			 <li><p>First Name:<span class="asterisk">&nbsp;*</span></p>
                    					 <input type="text" maxlength="50" name="firstname" id="firstname" value="<?php if(isset($result_edit)){ echo $result_edit[0]['firstname']; } ?>" />			
                    				 </li> 
                    				 <li><p>Last Name:<span class="asterisk">&nbsp;*</span></p>
                    					 <input type="text" maxlength="50" name="lastname" id="lastname" value="<?php if(isset($result_edit)){ echo $result_edit[0]['lastname']; } ?>" />
                           			</li>
                           			<li><p>Email:<span class="asterisk">&nbsp;*</span></p>
                    		             <span class="inpt_err">
                    		             <input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($result_edit)){ echo $result_edit[0]['email']; } ?>" <?php if(isset($result_edit)){ echo "readonly";}?> />
                           				</span>
                           			</li>		
                           			 <?php if(!isset($_REQUEST['edit'])){ ?>
                           			 <li><p>Password:<span class="asterisk">&nbsp;*</span></p>
                           			 	 <span class="inpt_err">
                           			 	 	<input type="password" name="password" id="password" value="" />
                           			 	 </span>
                           			 </li>
                           			   <?php } ?>
                           			  <li><p>DOB:<span class="asterisk">&nbsp;*</span></p>
                           				 <input type="text" readonly="readonly" name="dob" id="dob" readonly="readonly" 
                       				 			value="<?php if(isset($result_edit)){                       				 				   
													   echo date('m-d-Y',strtotime($result_edit[0]['dob'])); 
													   }?>" />		  	
                           			  </li>
                           			  <li><p>Gender:<span class="asterisk">&nbsp;</span></p>
                           			  	<div class="select_er">
	                           			  	<div class="select_main">
	                           			  	  <select class="drp_down" name="gender" id="gender" >
	                            				<option <?php if(isset($result_edit)){ echo $result_edit[0]['gender'] == 1 ? "selected" : ''; } ?> value="1">Male</option>
												<option <?php  if(isset($result_edit)){ echo $result_edit[0]['gender'] == 2 ? "selected" : ''; } ?> value="2">Female</option>
											  </select>	
											 </div> 
										 </div>
                           			  </li> 
                           			  <li><p>Ethnicity:<span class="asterisk">&nbsp;*</span></p>
                           			  	<div class="select_er">
	                           			  	<div class="select_main">
	                           			  	  <select class="drp_down" name="ethinicity" id="ethinicity" >
	                           			  	  	<option value="">Select Ethnicity</option>
                        						<?php foreach ($ethinicity_array as $value) {?>
												<option value="<?php echo $value['id']?>" <?php if(isset($result_edit)){ echo $result_edit[0]['ethinicity'] == $value['id'] ? "selected" : ''; } ?>><?php echo $value['name']?></option>
												<?php }?>
											  </select>	
											 </div> 
										 </div>
                           			  </li>                           			  
                           			  <li><p>Contact No:</p>
                           					<input type="text" maxlength="15" name="contact_no" id="contact_no" value="<?php if(isset($result_edit)){ echo $result_edit[0]['contact_no']; } ?>" />	  	
                           			  </li>
                           			   <div class="sec_4">
								  		<p></p>
								  			<a href="user.php" class="next cancel" id="prev1">Cancel</a>
								  			 <?php if(isset($_REQUEST['edit'])){ 
                                				if($_SESSION['user_permission']['user']['delete']){ ?>
                                				<a  class="next" onclick="return confirm('Are you sure you want to delete?');" href="user.php?delete_user=<?php 	echo $result_edit[0]['user_id'];?>">Delete</a>
                                				<?php } ?>
                                				<input type="submit" class="next" name="update_user" value="<?php echo $edit_button_text; ?>" />
                                			<?php }else{ ?>
                                				<input type="submit" class="next" name="add_user" value="<?php echo $add_button_text; ?>" />
                                			<?php } ?>
								  	    </div>
                    				</ul>
                    			</form>
                    		</div>
                    		</div>		
                          
                </section>	  
                
            <?php }else{ ?>
            
            
              <section class="content_in">
                	      <div class="sec_n0">
							 <ul>
							 	<li><p>User List</p></li>
							 	<li class="cunt"><h3>Total:<span id="totalchange"><?php echo count($result);?></span></h3></li>
							 	<li class="short">
								<span>Sort By:</span>
								<div class="select_main select2">
									<select  class="drp_down" id="sortbyfilter">
										<option value="0">User</option>
										<option value="1">Email</option>
									</select>
								</div>
							</li>
							 </ul>
						  </div>
                         
                         <div class="content_tbl"> 
                         		<div class="sec_n1">
									<ul>
										<li><span>Filter</span>
											<div class="select_main srch">
										  		<input type="text" id="myInputTextField" placeholder="Search..." >
					  		        		</div>
					  		        	</li>
				  					</ul>
								</div>
            	
                      			<div class="sec_n2">
                                <table class="table table-striped table-hover table_main" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Last Check-In Date</th>
                                            <th>Last Check-In Venue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                            
                                        <tr class="odd gradeX">
                                        	
                                        	<?php if($_SESSION['user_permission']['user']['view']){ ?>
                                        	<td> <a href="userinfo.php?edit=<?php echo $result[$i]['user_id'];  ?>"><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></a></td>
                                        	<?php }else{ ?>
                                        	<td><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></td>
                                        	<?php } ?>	
                                        		
                                            <td><?php echo $result[$i]['email'];?></td>
                                            <td><?php echo ($result[$i]['venuelasttime'])?date('m-d-Y',strtotime($result[$i]['venuelasttime'])):'-'; ?></td>
                                            <td><?php echo ($result[$i]['venuelastname'])?$result[$i]['venuelastname']:'-'; ?></td>
                                            
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                              </div>
                         </div>
              
    </section>
            <?php } ?>
    
    <?php include("template/footer.php"); ?>
    <script type="text/javascript">
    
    $(document).ready(function() {
    	
    	 $(".sfile").click(function(){
			 $("input[id='images']").click();
		});
	
	 	var oTable = $('#dataTables-example').dataTable({
 			"bLengthChange": false,
 			"oSearch": {"bSmart": false},
 			 bInfo: false,
 			"aoColumns": [
 			      { "bSortable": false },
	              { "bSortable": false },
	              { "bSortable": false },
	              { "bSortable": false },
	        ],
	        "fnDrawCallback": function(oSettings) {
	        	$("#totalchange").html(oSettings.fnRecordsDisplay());
				if($('ul.pagination li').length<=3)
				{
					$('.dataTables_paginate').hide();
				}
				else
				{
					$('.dataTables_paginate').show();
				}
	        	
	        	/*
		        if ($('#dataTables-example tr').length == 2) {
		       		 if($('#dataTables-example tr .dataTables_empty').length==1){
		        	 	$('.dataTables_paginate').hide();	
		        	 } 
		        	 else
		        	 {
		        	 	$('.dataTables_paginate').show();
		        	 }
		        }
		        else
		        {
		        	 $('.dataTables_paginate').show();
		         }
		        */ 
   			 }
   			 
        });
         		
       $(".fhead").hide();
       
       $('#myInputTextField').keyup(function(){
			  oTable.fnFilter($(this).val());
		})	
		
		<?php if(!isset($_REQUEST['add']) && !isset($_REQUEST['edit'])){ ?>
 			oTable.fnSort( [ [0,'asc']] );
 		<?php } ?>
 		
 		
 		
 		$('#sortbyfilter').change(function() {
		   	oTable.fnSort( [ [$(this).val(),'asc']] ); 
        });
 		
 		
        
        jQuery.validator.addMethod("checkemail", function(val, elem) {
	 	var result = false;
			$.ajax({
				url:'signup.php',
				type:'POST',
				data:'action=check_email&email='+val,
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
        
        
        
		jQuery.validator.addMethod("specialChars", function( value, element ) {
        var re = /^[ A-Za-z'-]*$/
         var key = value;
	     if (!re.test(key)) {
           return false;
        }
       return true;
    	}, "");
        
 
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
                	<?php if(!isset($_REQUEST['edit'])){ ?>
                	checkemail: true,
                	<?php } ?>
                },
                password: {
                	<?php if(!isset($_REQUEST['edit'])){ ?>
                	required: true,
                	<?php } ?>
                	minlength: 6,
	                maxlength: 20
                },
                dob: {
                	required: true,
                },
                ethinicity: {
                	required: true,
                }, 
                contact_no: {
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
                	<?php if(!isset($_REQUEST['edit'])){ ?>
                	checkemail: "This email id already exist please try another"
                	<?php } ?>
                },
                password: {
                <?php if(!isset($_REQUEST['edit'])){ ?>
                	required:"Please enter password",
                <?php } ?>
                	minlength: "Password must consist of 6-20 characters",
	                maxlength: "Password must consist of 6-20 characters"	
                },
                dob: {
                	required: "Please select dob",
                },
                ethinicity: {
                	required: "Please select ethnicity",
                },
                contact_no: {
                	number: "Please enter valid contact no",
                	minlength: "Must consist of 8-14 characters",
	                maxlength: "Must consist of 8-14 characters"
                }
            }
        });
    });
    </script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $(".paginate_button").click(function(){
                $('html,body').animate({ scrollTop: 0 },'slow',function(){});
            });
            
           
            $("#dob").datepicker({
            	changeYear: true,
            	changeMonth: true,
            	yearRange : '-100:-18',
            	defaultDate : '-18y',    
            	dateFormat: 'mm-dd-yy',
            	maxDate: '-18y',
            });
           
           // $( "#dob" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });
    </script>
<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<script type="text/javascript" src="template/js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="template/js/script.js"></script>