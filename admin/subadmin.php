<?php
include("include/subadmin.php");
include("template/header.php");
$add_button_text = "Add Employee";
$edit_button_text = "Update Employee";
?>

	 <link rel="stylesheet" type="text/css" href="template/css/imgareaselect-animated.css" />
	 
	 <div class="add_goal">
			<div class="ad_lft">
				  
				 <?php if(isset($_REQUEST['add'])){ ?>
                        <span class="pg_titl"><h1>Add Employee</h1></span>
                        <?php } else if(isset($_REQUEST['edit'])){?>
                        <span class="pg_titl"><h1>Update Employee</h1></span>
                        <?php } else {?>
                        	<span class="pg_titl"><h1>Employee</h1></span>
				 		<?php } ?>
			</div> 
			  <?php if(!isset($_REQUEST['add']) && !isset($_REQUEST['edit'])){ ?>
				<div class="pull-right op_sn">
					<a href="subadmin.php?add=true">
						<div class="add_btn">
							<span>+</span>
							<p>Add Employee</p>
						</div>
						</a>
				</div>
			<?php } ?>	
	 
	 
             <?php if(isset($_REQUEST['msg'])){
                switch($_REQUEST['msg']){   
                case "1":
                        $alert_type = "alert alert-danger alert-dismissable";
                        $msg = "Email already exist ";
                        break;
                case "2":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Employee added successfully";
                        break;
                case "3":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Employee profile updated successfully";
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
                        $msg = "Employee deleted successfully";
                        break;
				case "9":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Employee deactivated successfully";
                        break;
				case "10":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Employee activated successfully";
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
  						<li class="active"><a data-toggle="tab" href="#dealinfo">Employee Information</a></li>
  					</ul>
                    <div class="tab-content">
							<div id="dealinfo" class="tab-pane action_inner1 active">
                    			<ul>
                    				  <li class="pr_pickcr">
                    				  	<p>Profile Picture:</p>
                           			  	<span class="img_upld single_image">
											
												<?php if(isset($_REQUEST['edit'])){
													if($result_edit[0]['photo'] == ""){
												?>
												<img src="template/images/user1.png" style="width: 100px; height: 100px;" />
												<?php	
												} if($result_edit[0]['photo'] != ""){
												?>
												<img style="width: 100px; height: 100px;" src="uploads/crop/<?php echo $result_edit[0]['photo']; ?>" />
												<?php 
												}
												?>
                            	  				<?php } else{ ?>
                            	  				<img src="template/images/user1.png" style="width: 100px; height: 100px;" />
                            	  				<?php } ?>
                            	  				
                            	  				
											
										</span>
										
										
									<button class="sfile" onclick="return false;">Upload Photo</button>
									<input type="file" name="images" id="images" style="display: none;" accept="image/*"/>		
									<input type="hidden" name="single_image" id="single_image" value="">	
  									<input type="hidden" name="single_x" id="single_x"/>
  									<input type="hidden" name="single_y" id="single_y"/>
  									<input type="hidden" name="single_w" id="single_w"/>
  									<input type="hidden" name="single_h" id="single_h"/>
								 </li>
                           		
                    				<li><p>First Name:<span class="asterisk">&nbsp;*</span></p>
                    				 <input type="text" maxlength="30" name="firstname" id="firstname" value="<?php if(isset($result_edit)){ echo $result_edit[0]['firstname']; } ?>"  />			
                    				</li>
                    				<li><p>Last Name:<span class="asterisk">&nbsp;*</span></p>
                    					 <input type="text" maxlength="30" name="lastname" id="lastname" value="<?php if(isset($result_edit)){ echo $result_edit[0]['lastname']; } ?>" />
                           			</li>	
                    				<li><p>Email:<span class="asterisk">&nbsp;*</span></p>
                    		            <span class="inpt_err">
                    		             	<input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($result_edit)){ echo $result_edit[0]['email']; } ?>" <?php if(isset($result_edit)){ echo "readonly";}?>/>
                    		             </span>
                           			</li>			
                           			 <?php if(!isset($_REQUEST['edit'])){ ?>
                           			 <li><p>Password:<span class="asterisk">&nbsp;*</span></p>
                           			 	  <span class="inpt_err">
                           			 	  	<input type="password" name="password" id="password" value="" />
                           			 	  </span>	
                           			 </li>
                           			   <?php } ?>
                           		
                           			  <li><p>Contact No:<span class="asterisk">&nbsp;*</span></p>
                           					 <span class="inpt_err">
                           					 	<input type="text" maxlength="15" name="contact_no" id="contact_no" value="<?php if(isset($result_edit)){ echo $result_edit[0]['contact_no']; } ?>" />
                           					 	</span>	  	
                           			  </li>	
                           			
                           			
                           			 <div class="sec_2">
											<h2>Employee Permission</h2>
										</div>
										
										
													
                           			  <div class="sec_3 sub_mnx" >
                           			  	<li>
                           			  		<p>Venue:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venue_add" name="permissions_venue[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venue']['add']) echo "checked"; }?>>
							            		<label for="per_venue_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venue_edit" name="permissions_venue[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venue']['edit']) echo "checked"; }?>>
							            		<label for="per_venue_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venue_delete" name="permissions_venue[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venue']['delete']) echo "checked"; }?>>
							            		<label for="per_venue_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venue_view" name="permissions_venue[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venue']['view']) echo "checked"; }?>>
							            		<label for="per_venue_view" class="css-label">View</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venue_suspend" name="permissions_venue[suspend]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venue']['suspend']) echo "checked"; }?>>
							            		<label for="per_venue_suspend" class="css-label">Active / Deactive</label>
                        					</span>
                        				</li>
                        				<li>
                           			  		<p>Category:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_category_add" name="permissions_category[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['category']['add']) echo "checked"; }?>>
							            		<label for="per_category_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_category_edit" name="permissions_category[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['category']['edit']) echo "checked"; }?>>
							            		<label for="per_category_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_category_delete" name="permissions_category[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['category']['delete']) echo "checked"; }?>>
							            		<label for="per_category_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_category_view" name="permissions_category[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['category']['view']) echo "checked"; }?>>
							            		<label for="per_category_view" class="css-label">View</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_category_suspend" name="permissions_category[suspend]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['category']['suspend']) echo "checked"; }?>>
							            		<label for="per_category_suspend" class="css-label">Active / Deactive</label>
                        					</span>
                        				</li>
                        				<li>
                           			  		<p>Deals & Offers:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_deal_add" name="permissions_deal[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['offer_of_venue']['add']) echo "checked"; }?>>
							            		<label for="per_deal_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_deal_edit" name="permissions_deal[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['offer_of_venue']['edit']) echo "checked"; }?>>
							            		<label for="per_deal_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_deal_delete" name="permissions_deal[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['offer_of_venue']['delete']) echo "checked"; }?>>
							            		<label for="per_deal_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_deal_view" name="permissions_deal[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['offer_of_venue']['view']) echo "checked"; }?>>
							            		<label for="per_deal_view" class="css-label">View</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_deal_suspend" name="permissions_deal[suspend]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['offer_of_venue']['suspend']) echo "checked"; }?>>
							            		<label for="per_deal_suspend" class="css-label">Active / Deactive</label>
                        					</span>
                        				</li>
                        				<li>
                           			  		<p>Venue Employee:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venueemployee_add" name="permissions_venueemployee[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venueemployee']['add']) echo "checked"; }?>>
							            		<label for="per_venueemployee_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venueemployee_edit" name="permissions_venueemployee[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venueemployee']['edit']) echo "checked"; }?>>
							            		<label for="per_venueemployee_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venueemployee_delete" name="permissions_venueemployee[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venueemployee']['delete']) echo "checked"; }?>>
							            		<label for="per_venueemployee_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venueemployee_view" name="permissions_venueemployee[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venueemployee']['view']) echo "checked"; }?>>
							            		<label for="per_venueemployee_view" class="css-label">View</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_venueemployee_suspend" name="permissions_venueemployee[suspend]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['venueemployee']['suspend']) echo "checked"; }?>>
							            		<label for="per_venueemployee_suspend" class="css-label">Active / Deactive</label>
                        					</span>
                        				</li>
                        				
                        				<li>
                           			  		<p>Ethnicity:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="ethinicity_add" name="permissions_ethinicity[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['ethinicity']['add']) echo "checked"; }?>>
							            		<label for="ethinicity_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="ethinicity_edit" name="permissions_ethinicity[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['ethinicity']['edit']) echo "checked"; }?>>
							            		<label for="ethinicity_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="ethinicity_delete" name="permissions_ethinicity[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['ethinicity']['delete']) echo "checked"; }?>>
							            		<label for="ethinicity_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="ethinicity_view" name="permissions_ethinicity[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['ethinicity']['view']) echo "checked"; }?>>
							            		<label for="ethinicity_view" class="css-label">View</label>
                        					</span>
                        				</li>
                        				
                        				<li>
                           			  		<p>Manager:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_manger_add" name="permissions_manager[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['manager']['add']) echo "checked"; }?>>
							            		<label for="per_manger_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_manger_edit" name="permissions_manager[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['manager']['edit']) echo "checked"; }?>>
							            		<label for="per_manger_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_manger_delete" name="permissions_manager[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['manager']['delete']) echo "checked"; }?>>
							            		<label for="per_manger_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_manger_view" name="permissions_manager[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['manager']['view']) echo "checked"; }?>>
							            		<label for="per_manger_view" class="css-label">View</label>
                        					</span>
                        				</li>
                        				
                        				<li>
                           			  		<p>User:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_user_add" name="permissions_user[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['user']['add']) echo "checked"; }?>>
							            		<label for="per_user_add" class="css-label">Add</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_user_edit" name="permissions_user[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['user']['edit']) echo "checked"; }?>>
							            		<label for="per_user_edit" class="css-label">Edit</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_user_delete" name="permissions_user[delete]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['user']['delete']) echo "checked"; }?>>
							            		<label for="per_user_delete" class="css-label">Delete</label>
                        					</span>
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_user_view" name="permissions_user[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['user']['view']) echo "checked"; }?>>
							            		<label for="per_user_view" class="css-label">View</label>
                        					</span>
                        				</li>
                        				
                        				<li>
                           			  		<p>Package:</p>
											<!--<span>
							            		<input type="checkbox" class="css-checkbox" id="per_package_edit" name="permissions_package[edit]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['package']['edit']) echo "checked"; }?>>
							            		<label for="per_package_edit" class="css-label">Edit</label>
                        						</span>-->
                        					<span>
							            		<input type="checkbox" class="css-checkbox" id="per_package_view" name="permissions_package[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['package']['view']) echo "checked"; }?>>
							            		<label for="per_package_view" class="css-label">View</label>
                        					</span>
                        					<!--<span>
							            		<input type="checkbox" class="css-checkbox" id="per_package_suspend" name="permissions_package[suspend]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['package']['suspend']) echo "checked"; }?>>
							            		<label for="per_package_suspend" class="css-label">Active / Deactive</label>
                        					</span>-->
                        				</li>
                        				
                        			
                        				<li>
                           			  		<p>Discount:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_discount_add" name="permissions_discount[add]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['discount']['add']) echo "checked"; }?>>
							            		<label for="per_discount_add" class="css-label">Add / Delete</label>
                        					</span>
                        					<!--<span>
							            		<input type="checkbox" class="css-checkbox" id="per_discount_suspend" name="permissions_discount[suspend]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['discount']['suspend']) echo "checked"; }?>>
							            		<label for="per_discount_suspend" class="css-label">Active / Deactive</label>
                        					</span>-->
                        				</li>
                        				

                        				
                        				<li>
                           			  		<p>Report:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_report_view" name="permissions_report[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['report']['view']) echo "checked"; }?>>
							            		<label for="per_report_view" class="css-label">View</label>
                        					</span>
                        				</li>
                        				
                        				<li>
                           			  		<p>Mail:</p>
											<span>
							            		<input type="checkbox" class="css-checkbox" id="per_mail_view" name="permissions_mail[view]" value="1" <?php if(isset($result_edit)){ if($result_edit['permission']['notification']['view']) echo "checked"; }?>>
							            		<label for="per_mail_view" class="css-label">Send</label>
                        					</span>
                        				</li>
                        				
                        				
                        			</div>
										
										
                           			  <div class="sec_4" >
								  		<p></p>
								  			<a href="subadmin.php" class="next cancel">Cancel</a>
								  			 <?php if(isset($_REQUEST['edit'])){ 
								  			 		if(!$result_edit[0]['is_deactive']){
								  			 	?>
								  			 		<a class="de_active" href="subadmin.php?deactive=<?php echo $result_edit[0]['user_id']; ?>" onclick="return DeactiveConfirm();">Deactivate</a>
								  			 		<?php }else{ ?>
								  		 			<a class="active_grn" href="subadmin.php?active=<?php echo $result_edit[0]['user_id']; ?>">Activate</a>
								  			 		<?php }?>
								  			 		<a  class="next" onclick="return confirm('Are you sure you want to delete?');" href="subadmin.php?delete_user=<?php echo $result_edit[0]['user_id']; ?>">Delete</a>
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
							 	<li><p>Employee List</p></li>
							 	<li class="cunt"><h3>Total: <span id="totalchange"><?php echo count($result);?></span></h3></li>
							 	<li class="short">
								<span>Sort By:</span>
								<div class="select_main select2">
									<select  class="drp_down" id="sortbyfilter">
										<option value="0">Employee</option>
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
					  		        	<li>
									  			<input type="radio" name="chk1"  id="yes1" checked="checked"/>
									  			<label for="yes1">Activate Employee</label>
									  			<input type="radio" name="chk1" id="no1"/>
									  			<label for="no1">Deactivate Employee</label>
									  	</li>
				  					</ul>
								</div>
            	
                      			<div class="sec_n2 table_scrl">
                                <table class="table table-striped table-hover table_main" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Contact No</th>
                                             <th style="display: none;">-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                        <tr class="odd gradeX">
                                            <td><a href="subadmininfo.php?edit=<?php echo $result[$i]['user_id'];  ?>"><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></a></td>
                                            <td><?php echo $result[$i]['email'];?></td>
                                            <td>
                                           		<?php if($result[$i]['is_deactive']==0) { ?>
                                           		<span class="pri-sm"></span>
                                           		<?php } ?>
                                           		<?php if($result[$i]['is_deactive']==1) { ?>
                                           		<span class="nopri-sm"></span>
                                           		<?php } ?>
                                           </td>
                                            <td><?php echo $result[$i]['contact_no']; ?></td>
                                            <td style="display:none;">
                                           		<?php if($result[$i]['is_deactive']==0) { ?>
                                           		{
                                           		<?php } ?>
                                           		<?php if($result[$i]['is_deactive']==1) { ?>
                                           		}
                                           		<?php } ?>
                                           </td>
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
    
    
    function DeactiveConfirm(){
		var r=confirm('<?php echo DEACTIVE_CONFIRM_MESSAGE; ?>');
		if(r==true)
	  	{
	  		return true;
	  	}
		else
	  	{
	  		return false;
	  	}
	}
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
	              { "sType": "html","bSortable": false },
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
 			oTable.fnFilter('{',4, true);
 			 			
 		<?php } ?>
 		
 		
 			$('#sortbyfilter').change(function() {
		   	oTable.fnSort( [ [$(this).val(),'asc']] ); 
        });
 		
 		$('#yes1').click(function() { 
 			oTable.fnFilter('{',4, true);
            // oTable.fnFilter('<span class="pri-sm"></span>',2, true);
        });
        $('#no1').click(function() { 
        	oTable.fnFilter('}',4, true);
            // oTable.fnFilter('<span class="nopri-sm"></span>',2, true);
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
                contact_no: {
                	required: "Please enter contact no",
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
        });
    </script>
<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script type="text/javascript" src="template/js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="template/js/script.js"></script>
