<?php

include("include/manager.php");

if($_SESSION['user']['user_type']==1 or $_SESSION['user']['user_type']==4)
{
	header("Location: dashboard.php");
}
else
{
	header("Location: venue.php");
}	
include("template/header.php");

        ?>
        <section class="content_in">
                	   
                          <div class="sec_n0">
							 <ul>
							 	<li><p>Manage List</p></li>
							 </ul>
						  </div>
                         
                         <div class="content_tbl"> 
                      			<div class="sec_n2">
                                <table class="table table-striped table-hover table_main" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>DOB</th>
                                            <th>Gender</th>
                                            <th>Contact No</th>
                                           <th style="width: 150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                         for($i=0;$i<count($result);$i++){ ?>
                                            
                                        <tr class="odd gradeX">
                                            <td style="width:5%"><?php echo $result[$i]['user_id']; ?></td>
                                            <td style="width:16%"><?php echo $result[$i]['firstname'].' '.$result[$i]['lastname']; ?></td>
                                            <td style="width:16%"><?php echo $result[$i]['email'];?></td>
                                            <td style="width:15%;"><?php echo $result[$i]['dob']; ?></td>
                                            <td style="width:10%;">
                                            	<?php 
                                            	if($result[$i]['gender']==1)
                                            	{
                                            		echo "Male";
												}
												else
												{
													echo "Female";
												}
												?>
                                            	
                                            	</td>
                                            <td><?php echo $result[$i]['contact_no']; ?></td>
                                            <td class="center action">
                                                <a href="manager.php?edit=<?php echo $result[$i]['user_id'];  ?>"><span class="edit_sm"></span></a>
                                                <a href="manager.php?delete_user=<?php echo $result[$i]['user_id'];?>" onclick="return confirm('<?php echo DELETE_CONFIRM_MESSAGE; ?>');"><span class="delete_sm"></span></a>
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
 	    $('#dataTables-example').dataTable({
            "aoColumns": [
	              null,
	              null,
	              { "bSortable": false },
	             { "bSortable": false },
	              { "bSortable": false },
	              { "bSortable": false },
	              { "bSortable": false }
            ]
        });
        
          $(".paginate_button").click(function(){
                $('html,body').animate({ scrollTop: 0 },'slow',function(){});
            });
 
        
    });
    </script>