<?php
include("include/timelog.php");
include("template/header.php");


global $DAO;
$sql = "SELECT sum(count) AS totalcount FROM `app_count`";
$result_app = $DAO->select($sql);
?>
<style>
#dataTables-example tr td {
	height:35px; 
}
</style>
<div class="add_goal">
			<div class="ad_lft">
				<span class="pg_titl"><h1>Statistic</h1></span>
			</div> 
		</div>
		<section class="content_in">
		<div class="row-cntn">
			<div class="col-md-4">
				<div class="w-data user">
					<div><span id="tuser"><?php echo $userresult[0]['users']?></span>Total Users</div>
					<span class="d-img dimg1"></span>
				</div>
			</div>
			
			
			<div class="col-md-4">
				<div class="w-data vanue">
					<div><span id="tvenue"><?php echo $result_venue[0]['venue']?></span>Total Venues</div>
					<span class="d-img dimg1"></span>
				</div>
			</div>
			
			
			<div class="col-md-4">
				<div class="w-data chk-ins">
					<div><span id="tcheckout"><?php echo $result_app['0']['totalcount'];?></span>Download App</div>
					<span class="d-img dimg1"></span>
				</div>
			</div>
		</div>
	</section>
		
	 	<div class="add_goal">
			<div class="ad_lft">
				<span class="pg_titl"><h1>Time Log Book</h1></span>
			</div> 
		</div>
		
		<section class="content_in">
				 <div class="sec_n0">
					 <ul>
					 	<li><p>Time Log Information</p></li>
					 	<li class="cunt"><h3>Total: <span id="totalchange"><?php echo count($result);?></span></h3></li>
					 	<li class="short" style="display: none;">
								<span>Short By:</span>
								<div class="select_main select2">
									<select  class="drp_down" id="sortbyfilter">
										<option value="1">User</option>
										<option value="3">Total Login Time</option>
									</select>
								</div>
						</li>
					 </ul>
				 </div>
		            
            	<div class="content_tbl">
		 			<div class="sec_n1">
					<ul>
						<li>
		  		        	<span>Filter</span>
							<div class="select_main srch">
						  		<input type="text" id="myInputTextField" placeholder="Search..." >
					  		</div>
					  	</li>
		  				 <li>
					  			<span>User Role</span>
					  			<div class="select_main select2">
						  			<select name="user_type" id="user_type" class="drp_down">
				                		<option value="">All Roles</option>
				                		<option value="Admin Employee">Admin Employee</option>
				                		<option value="manager">Manager</option>
				                		<option value="Venue Employee">Venue Employee</option>
				                		<option value="User">User</option>
				                		
				                	</select>
		  						</div>
		  				</li>
		  			</ul>
			</div>
			 <div class="sec_n2">
	                 <table class="table table-striped table-hover table_main timelog_book" id="dataTables-example">
                               <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>User Role</th>
                                             <th>Email</th>
                                            <th>Total Login Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></td>
                                            <td><?php 
                                            	if($result[$i]['user_type']==4)
                                            		echo "Admin Employee";
												else if($result[$i]['user_type']==2)
                                            		echo "Manager";
												else if($result[$i]['user_type']==3)
                                            		echo "User";
												else if($result[$i]['user_type']==5)
                                            		echo "Venue Employee";
												?>
                                            </td>
                                            <td><?php echo $result[$i]['email']; ?></td>
                                            <td>                                            	
                                            	<?php echo $result[$i]['timespent']; ?>
                                            </td>
                                            
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                             </div>
                        </div>
               	</section>
               
    
    <?php include("template/footer.php"); ?>
    <script type="text/javascript">
    
    $(document).ready(function() {
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
		         }*/
   			 }
        });
        
        $(".fhead").hide();		
		$('#myInputTextField').keyup(function(){
			  oTable.fnFilter($(this).val());
		})
		
		
		
        $('#user_type').change( function() { 
             //oTable.fnFilter(jQuery(this).val(), 2, true);
          	//oTable.fnFilter("^" + jQuery(this).val() + "$",2);
          	 /*
          	 if(jQuery(this).val())
          	 {	
          	 	oTable.fnFilter( "^"+jQuery(this).val() +"$", 3 , true);
          	 }
          	 else
          	 {
          	 	oTable.fnFilter(jQuery(this).val(), 3, true);
          	 }	
          	 */
          	 oTable.fnFilter(jQuery(this).val(), 1, true);
        });
 		
 		
       	$('#sortbyfilter').change(function() {
       		oTable.fnSort( [ [$(this).val(),'asc']] ); 
        });
        
        
        $(".paginate_button").click(function(){
               $('html,body').animate({ scrollTop: 0 },'slow',function(){});
        });
        
       
    });
    </script>