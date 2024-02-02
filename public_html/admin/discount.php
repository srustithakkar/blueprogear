<?php
include("include/discount.php");
include("template/header.php");
?>
<style>
#dataTables-example tr td {
	height:35px; 
}

.sec_page {
    display: inline-block;
    float: none;
    min-width: 1200px;
    width: 100%;
}

#dataTables-example_wrapper {
	 overflow-x: auto;
	 overflow-y: hidden;
}
#dataTables-example_wrapper tr th.th1 {
	 min-width: 70px!important; 
}
#dataTables-example_wrapper tr th.th2 {
	 min-width: 106px!important; 
}
#dataTables-example_wrapper tr th.th3 {
	 min-width: 150px!important; 
}
#dataTables-example_wrapper tr th.th4 {
	 min-width: 80px!important; 
}
#dataTables-example_wrapper tr th.th5 {
	 min-width: 150px;!important; 
}
#dataTables-example_wrapper tr th.th6 {
	 min-width: 250px;!important; 
}
#dataTables-example_wrapper tr th.th7 {
	 min-width: 86px;!important; 
}
#dataTables-example_wrapper tr th.th8 {
	 min-width: 101px;!important; 
}
tr td {
    word-break: keep-all;
}
.disc_select { 
background-position: 232px 9px; 
width: 250px; 
}
</style>

		
	 	<div class="add_goal">
			<div class="ad_lft">
				<span class="pg_titl"><h1>Discount</h1></span>
			</div> 
			<?php if(isset($_REQUEST['msg'])){
                switch($_REQUEST['msg']){   
                
                case "1":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Discount added successfully";
                        break;
                case "2":
                        $alert_type = "alert alert-success alert-dismissable";
                        $msg = "Discount removed successfully";
                        break;
                case "4":
                        $alert_type = "alert alert-danger alert-dismissable";
                        $msg = "Something went wrong , please try again.";
                        break;
                }

	?>
			<div class="<?php echo $alert_type; ?>">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<?php echo $msg; ?>
			</div>
	<?php } ?>
		</div>
		
		<section class="content_in">
				 <div class="sec_n0">
					 <ul>
					 	<li><p>Discount List</p></li>
					 	<li class="cunt"><h3>Total: <span id="totalchange"><?php echo count($result);?></span></h3></li>
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
			 <div class="sec_n2 discount_tbl">
			 	
			 	
			 	 
	                 <table class="table table-striped table-hover table_main" id="dataTables-example">
                               <thead>
                                        <tr>
                                            <th class="th2">Venue</th>
                                            <th class="th3">Manager</th>
                                            <th class="th4">Category</th>
                                            <th class="th5">Email</th>
                                            <th class="th6">Discount</th>
                                            <th class="th7">Value</th>
                                            <th class="th8">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                         for($i=0;$i<count($result);$i++){ ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $result[$i]['name'];?></td>
                                            
                                            <?php if($result[$i]['firstname']) { ?>
                                            <td><?php echo $result[$i]['firstname'] . ' ' . $result[$i]['lastname']; ?></td>
                                            <?php }else{ ?>
                                            <td>-</td>
                                            <?php } ?>
                                            
                                            
                                            
                                            <td><?php echo $result[$i]['categoryname'];?></td>
                                            <td><?php echo $result[$i]['email'];?></td>
                                            
                                            <?php if($result[$i]['discount_id']){ ?>
                                             <td><?php echo $result[$i]['discountname'];?></td>
                                            <?php }else{ 
                                            	
                                            	$paymentlast =  $venueobj->lastpaymentvenuedetailbyid($result[$i]['venue_id']);
												
												
												?>                                            
                                             <td>
                                             	<div class="disc_select">
                                             		<select name="discount_<?php echo $result[$i]['venue_id'];?>" id="discount_<?php echo $result[$i]['venue_id'];?>">
                                             			<option value="">Select Discount</option>
                                             		<?php foreach ($discountarray as $value) {
                                             			
														if($paymentlast[0]['subscription_id']==3 and $value['id'] == 6){  
                                             			 
														}
														else
														{
															echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
														}	
																	
													 }
													 ?>
												</select>
												</div>
                                            </td>
                                            <?php } ?>
                                            
                                            
                                            <?php if($result[$i]['discount_id']){ ?>
                                            <td><?php echo $result[$i]['value'];?></td>
                                            <?php }else{ ?>
                                            <td><input type="text" class="valuetext" name="value_<?php echo $result[$i]['venue_id'];?>" id="value_<?php echo $result[$i]['venue_id'];?>" /></td>
                                            <?php } ?>
                                            
                                           
                                            
                                            <?php if($result[$i]['discount_id']){ ?>
                                            <td class="text-center"><a href="discount.php?deactive_venue=<?php echo $result[$i]['venue_id'];?>" onclick="return confirmbox();"><span class="apply_disbel">DISABLE</span></a></td>
                                            <?php }else{ ?>
                                            <td class="text-center"><span class="apply_btn" onclick="discountapply('<?php echo $result[$i]['venue_id'];?>');">APPLY</span></td>
                                            <?php } ?>
                                            
                                        </tr>
                                        <?php } ?>
                                       
                                    </tbody>
                                    
                                    
                                     
                                </table>
                        
                             </div>
                        </div>
               	</section>
               	
               <?php foreach ($subscriptionarray as $value) { ?>
               	
               			<input type="hidden" name="subscription_<?php echo $value['id'];?>" id="subscription_<?php echo $value['id'];?>" value="<?php echo $value['price'];?>">
               		    
               <?php } ?>
    
    <?php include("template/footer.php"); ?>
    <script type="text/javascript">
    
    
    
     function confirmbox(){
       var r=confirm("Are sure to disable this discount ?")
        if (r==true)
          return true;
        else
          return false;
     }
        
    function discountapply(val)
   {
   		var discount_type = $("#discount_"+val).val();
   		var discount_value = $.trim($("#value_"+val).val());
   		
   		if(discount_type=="")
   		{
   			alert("Please select discount type");
   			return false;
   		}
   		if(discount_value=="")
   		{
   			alert("Please enter discount value");
   			return false;
   		}
   		if(discount_value<=0)
   		{
   			alert("Please enter discount value greater than 0");
   			return false;
   			
   		}
   		
   		
   		if(isNaN(discount_value))
   		{
   			alert("Please enter numeric value");
   			return false;
   		}
   		if(discount_type == 1|| discount_type == 4)
   		{
   			
   			if(discount_value>99)
   			{
   				alert("Please enter value up to 99");
   				return false;
   			}
   		}
   		if(discount_type == 2)
   		{
   			var subvalue =	$("#subscription_3").val();
   			
   			var dparser = 	parseFloat(discount_value,10);
   			var sparser = 	parseFloat(subvalue,10); 
   		
   			if(dparser >= subvalue)
   			{
   				alert("Please enter value less than package price ("+subvalue+")");
   				return false;
   			}
   		}
   		
   		if(discount_type == 5)
   		{
   			var subvalue =	$("#subscription_2").val();
   			var dparser = 	parseFloat(discount_value,10);
   			var sparser = 	parseFloat(subvalue,10); 
   		
   			if(dparser >= subvalue)
   			{
   				alert("Please enter value less than package price ("+subvalue+")");
   				return false;
   			}	
   		}
   		
   		if(discount_type == 3 || discount_type == 6)
   		{
   			if(discount_value.indexOf('.') >0)
   			{
   				alert("Please enter number value");
   				return false;
   			}
   		}
   		
   		var urlstring = 'add='+val+'&type='+discount_type+'&value='+discount_value;
   		
   		location.href="discount.php?"+urlstring;
   		
   		return true;
   }
   
   
   jQuery.fn.forceNumeric = function () {

     return this.each(function () {
         jQuery(this).keydown(function (e) {
             var key = e.which || e.keyCode;
             if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
             // numbers   
                 key >= 48 && key <= 57 ||
             // Numeric keypad
                 key >= 96 && key <= 105 ||
             // . on keypad
                ((key == 110 || key == 190) && (jQuery(this).val().indexOf(".")<0)) ||
             // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
             // Home and End
                key == 35 || key == 36 ||
             // left and right arrows
                key == 37 || key == 39 || 
             // Del and Ins
                key == 46 || key == 45)
                 return true;

             return false;
         });
     });
 }

   
   
    $(document).ready(function() {
    	
    	
    	 jQuery(".valuetext").forceNumeric();
    	 
    	 $('.valuetext').keypress(function(e) {
    	 	var key = e.which || e.keyCode;
    	 	var disval =this.value;
    	 	var currentid = $(this).attr('id');
    	 	var res = currentid.split("_"); 
    	 	var discountype = $("#discount_"+res[1]).val();
    	 	
    	 	if(discountype == 3 || discountype == 6)
    	 	{
    	 		if(key == 46)
    	 		{
    	 			return false;
	    	 	}
	       }  
	            
        });
        
        
        $('.valuetext').blur(function() {
        	var disval =this.value;
            if(disval.indexOf('.') >0)
	   		{
	   			var amt = parseFloat(this.value);
	           	$(this).val(amt.toFixed(2));
	        }  
		});

		$("select").change(function() {
			var currentid = $(this).attr('id');
			var discouttype = $(this).val();
    	 	var res = currentid.split("_"); 
    	 	$("#value_"+res[1]).val('');
    	 	$("#value_"+res[1]).removeAttr("maxlength");
    	 	if(discouttype == 3 || discouttype == 6)
    	 	{
    	 		$("#value_"+res[1]).attr('maxlength',3);
    	 	}
			
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
	              { "sType": "html","bSortable": false },
	              { "sType": "html","bSortable": false },
	              { "sType": "html","bSortable": false },
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
		
       
        $(".paginate_button").click(function(){
               $('html,body').animate({ scrollTop: 0 },'slow',function(){});
        });
        
       
    });
    </script>