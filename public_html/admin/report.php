<?php
include("include/report.php");
include("template/header.php");
?>
<style>
#dataTables-example tr td {
	height:35px; 
}
</style>
	 	<div class="add_goal">
			<div class="ad_lft">
				<span class="pg_titl"><h1>Report</h1></span>
			</div> 
		</div>
		
		<section class="content_in">
				 <div class="sec_n0">
					 <ul>
					 	<li><p>Payment History</p></li>
					 	<li class="cunt"><h3>Total: <span id="totalchange"><?php echo count($result);?></span></h3></li>
					 	<li class="short">
								<span>Sort By:</span>
								<div class="select_main select2">
									<select  class="drp_down" id="sortbyfilter">
										<option value="0">Venue</option>
										<option value="3">Start Date</option>
										<option value="4">End Date</option>
										<option value="5">Payment Date</option>
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
		  			<?php if(isset($managerresult)){ ?>        
		  		<li>
		  			<span>Venue</span>
		  			<div class="select_main select2">
		  			<select name="venue_search" id="venue_search" class="drp_down">
                		<option value="">All Venues</option>
                		<?php foreach ($venueresult as $value) {?>
								<option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>	
						<?php } ?>
                	</select>
		  		</div>
		  		</li>
		  	  		
		  		<li>
		  			<span>Manager</span>
		  			<div class="select_main select2">
		  			<select name="venue_price" id="venue_price" class="drp_down">
                		<option value="">All Managers</option>
                		<?php foreach ($managerresult as $value) {?>
                		<option value="<?php echo $value['firstname'].' '.$value['lastname'];?>"><?php echo $value['firstname'].' '.$value['lastname'];?></option>
                		<?php } ?>
                	</select>
		  		</div>
		  		</li>
		  		<?php } else { ?>
		  		 <li>
		  			<span>Venue</span>
		  			<div class="select_main select2">
		  			<select name="venue_search" id="venue_search" class="drp_down">
                		<option value=""></option>
                		<?php foreach ($venueresult as $value) {?>
								<option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>	
						<?php } ?>
                	</select>
		  		</div>
		  		</li>
		  		<?php } ?>
		  		</ul>
			</div>
			 <div class="sec_n2">
	                 <table class="table table-striped table-hover table_main report_tbbl" id="dataTables-example">
                               <thead>
                                        <tr>
                                            <th>Venue</th>
                                            
                                            <?php  if($_SESSION['user']['user_type']=="1"){ ?>
                                            <th>Manager</th>
                                             <?php } ?>
                                             
                                            <th>Price ($)</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                        <tr class="odd gradeX">
                                            <td ><?php echo $result[$i]['venuename']; ?></td>
                                            
                                           <?php  if($_SESSION['user']['user_type']=="1"){ ?>
                                            <td><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></td>
                                            <?php } ?>
                                            
                                            <td><?php echo $result[$i]['price'];?></td>
                                            
                                            <td>                                            	
                                            	<?php echo date('m-d-Y',strtotime($result[$i]['start'])); ?>
                                            </td>
                                            
                                            <td>                                            	
                                            	<?php echo date('m-d-Y',strtotime($result[$i]['end'])); ?>
                                            </td>
                                            
                                            <td>
                                            	<?php echo date('m-d-Y',strtotime($result[$i]['createtime'])); ?>
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
 			<?php  if($_SESSION['user']['user_type']=="1"){ ?>
 			      { "bSortable": false },
 			      <?php } ?>
	              { "bSortable": false },
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
		
        $('#venue_search').change( function() { 
             oTable.fnFilter(jQuery(this).val(), 0, true);
        });
 		
 		$('#venue_price').change( function() { 
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