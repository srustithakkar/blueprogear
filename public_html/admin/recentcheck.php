<?php
include("include/ethinicity.php");
if($_SESSION['user']['user_type']==5 || $_SESSION['user']['user_type']==2)
{
	header("Location: permissionerror.php");
    die();
}
$dashboard = (object) new dashboard();	
$result = $dashboard->venuevisited(0);
include("template/header.php");
?>
<style>
tr td {
    word-break: keep-all;
}
</style>

		
	 	<div class="add_goal">
			<div class="ad_lft">
				<span class="pg_titl"><h1>Recent Check-In</h1></span>
			</div> 
		</div>
		
		<section class="content_in">
				 <div class="sec_n0">
					 <ul>
					 	<li><p>Recent Check-In List</p></li>
					 	<li class="cunt"><h3>Total: <span id="totalchange"><?php echo count($result);?></span></h3></li>
					 	<!--<li class="short" style="display: none;">
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
		  			</ul>
			</div>
			 <div class="sec_n2">
	                 <table class="table table-striped table-hover table_main" id="dataTables-example">
                               <thead>
                                        <tr>
                                            <th class="th2">User</th>
                                            <th class="th3">Check-In Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $result[$i]['name'];?> - Check in by
											<?php echo $result[$i]['firstname'].' '.$result[$i]['lastname'];?>
											</td>
											<td>
												<?php echo date('m-d-Y',strtotime($result[$i]['create_on'])); ?>
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
 			 "aaSorting": [],
 			"aoColumns": [
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
		
       $('#user_type').change( function() { 
             oTable.fnFilter(jQuery(this).val(), 2, true);
        });
 		
 		$('#sortbyfilter').change(function() {
       		oTable.fnSort([[$(this).val(),'asc']]); 
        });
        
        $(".paginate_button").click(function(){
               $('html,body').animate({ scrollTop: 0 },'slow',function(){});
        });
        
       
    });
    </script>