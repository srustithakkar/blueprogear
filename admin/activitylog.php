<?php
include("include/activitylog.php");
include("template/header.php");
?>
<style>
#dataTables-example tr td {
	height:35px; 
}

.sec_page {
    /*display: inline-block;
    float: none;
    min-width: 1091px;
    width: 100%;*/
}

#dataTables-example_wrapper {
	 overflow-x: auto;
	 overflow-y: hidden;
}
#dataTables-example_wrapper tr th.th1 {
	 min-width: 50px!important; 
}
#dataTables-example_wrapper tr th.th2 {
	 min-width:170px!important; 
	 width: 170px!important;
}
#dataTables-example_wrapper tr th.th3 {
	 min-width: 150px!important; 
}
#dataTables-example_wrapper tr th.th4 {
	 min-width: 290px!important; 
}
#dataTables-example_wrapper tr th.th5 {
	 min-width: 190px!important; 
}
tr td {
    word-break: keep-all;
}


</style>

		
	 	<div class="add_goal">
			<div class="ad_lft">
				<span class="pg_titl"><h1>Activity Log</h1></span>
			</div> 
		</div>
		
		<section class="content_in">
				 <div class="sec_n0">
					 <ul>
					 	<li><p>Activity Log List</p></li>
					 	<!--<li class="cunt"><h3>Total: <?php echo count($result);?> </h3></li>
					 	<li class="short" style="display: none;">
								<span>Short By:</span>
								<div class="select_main select2">
									<select  class="drp_down" id="sortbyfilter">
										<option value="1">Name</option>
										<option value="3">Total Time</option>
									</select>
								</div>
						</li>-->
						
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
				                		<option value="Super Admin">Super Admin</option>
				                		<option value="Admin Employee">Admin Employee</option>
				                		<option value="manager">Manager</option>
				                		<option value="Venue Employee">Venue Employee</option>
				                		<!--<option value="User">User</option>-->
				                		
				                	</select>
		  						</div>
		  				</li>
		  			</ul>
			</div>
			 <div class="sec_n2">
	                 <table class="table table-striped table-hover table_main" id="dataTables-example">
                               <thead>
                                        <tr>
                                            <th class="th2">User</th>
                                            <th class="th3">User Role</th>
                                            <th class="th4">Activity Log</th>
                                            <th class="th5">Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></td>
                                            <td><?php 
                                            	if($result[$i]['user_type']==1)
                                            		echo "Super Admin";
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
                                            <td>                                            	
                                            	<?php echo $result[$i]['message']; ?>
                                            </td>
                                            <td>                                            	
                                            	<?php echo date('m-d-Y H:i:s',strtotime($result[$i]['created'])); ?>
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
   			 }
        });
        
        $(".fhead").hide();		
        
		$('#myInputTextField').keyup(function(){
			  oTable.fnFilter($(this).val());
		})
		
       $('#user_type').change( function() { 
             oTable.fnFilter(jQuery(this).val(), 1, true);
        });
 		
 		$('#sortbyfilter').change(function() {
       		oTable.fnSort([[$(this).val(),'asc']]); 
        });
        
        $(".paginate_button").click(function(){
               $('html,body').animate({ scrollTop: 0 },'slow',function(){});
        });
        
       
    });
    </script>