<?php
include("include/user.php");
include("template/header.php");
?>
	 
	<div class="add_goal">
			<div class="ad_lft">
	             	<span class="pg_titl"><h1>User View</h1></span>
			</div> 
     </div>
           <section class="content_in">
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
									  </li>
                           			 <li><p>First Name:</p><em><?php echo $result_edit[0]['firstname']; ?></em></li>			
                    				 <li><p>Last Name:</p><em><?php echo $result_edit[0]['lastname']; ?></em></li>
                           			 <li><p>Email:</p><em><?php echo $result_edit[0]['email']; ?></em></li>
                           			 <li><p>DOB:</p>
                           			 	<em>
                           					<?php echo date('m-d-Y',strtotime($result_edit[0]['dob'])); ?> 
										</em>			   		  	
                           		   </li>
                           		    <li><p>Gender:</p>
                           		    	<em>
                           		    			<?php 
                           		    				if($result_edit[0]['gender'] == 1)
                           		    				{
                           		    					echo "Male";
													}
													if($result_edit[0]['gender'] == 2)
                           		    				{
                           		    					echo "Female";
													}
													?>		
                           			 	</em>		
                           		   </li> 
                           			<li><p>Ethnicity:</p>
                           				<em>
                        					<?php   $ethinicityname = '-';
                        					         foreach ($ethinicity_array as $value) {
	                        							if($result_edit[0]['ethinicity'] == $value['id'])
														{
															 $ethinicityname =  $value['name'];
														}	
												 }
												 echo $ethinicityname;
												 ?>
												 
										 </em>
                           			  </li>                           			  
                           			  <li><p>Contact No:</p>
                           					<em><?php echo $result_edit[0]['contact_no'];?></em>	  	
                           			  </li>	
                           			   <div class="sec_4">
								  		<p></p>
								  			<a href="user.php" class="next cancel" id="prev1">Cancel</a>
								  			<?php if($_SESSION['user_permission']['user']['edit']){ ?>
								  			<a href="user.php?edit=<?php echo $result_edit[0]['user_id'];?>" class="edit-btn">Edit</a>
								  			
								  			<?php if($result_edit[0]['email'] !=""){?>
								  			<a href="user.php?request_password=<?php echo $result_edit[0]['user_id']; ?>" class="next" style="margin-left: 10px;">Request Password</a>
								  			<?php } ?>
								  			
								  			<?php } ?>
								  	    </div>
                    				</ul>
                    			
                    		</div>
                    		</div>		
                          
                </section>	  
                
    <?php include("template/footer.php"); ?>  