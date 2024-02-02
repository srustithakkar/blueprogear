<?php
include("include/product.php");
// print_r($_SESSION['user']);die();
include("template/header.php");
$add_button_text = "Add Product";
$edit_button_text = "Update Product";
?>
<link rel="stylesheet" type="text/css" href="template/css/imgareaselect-animated.css" />
<<script src="//cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
<style>
    #user_form .select_er label.error {
        width: 58%;
    }
</style>	 

<div class="add_goal">
    <div class="ad_lft">

        <?php if (isset($_REQUEST['add'])) { ?>
            <span class="pg_titl"><h1>Add Product</h1></span>
        <?php } else if (isset($_REQUEST['edit'])) { ?>
            <span class="pg_titl"><h1>Update User</h1></span>
        <?php } else { ?>
            <span class="pg_titl"><h1>Product</h1></span>
        <?php } ?>
    </div> 
    <?php
    if ($_SESSION['user_permission']['user']['add']) {

        if (!isset($_REQUEST['add']) && !isset($_REQUEST['edit'])) {
            ?>
            <div class="pull-right op_sn">
                <a href="product.php?add=true">
                    <div class="add_btn">
                        <span>+</span>
                        <p>Add Product</p>
                    </div>
                </a>
            </div>
        <?php }
    } ?>	

    <?php
    if (isset($_REQUEST['msg'])) {
        switch ($_REQUEST['msg']) {
            case "1":
                $alert_type = "alert alert-danger alert-dismissable";
                $msg = "Email already exist ";
                break;
            case "2":
                $alert_type = "alert alert-success alert-dismissable";
                $msg = "Product added successfully";
                break;
            case "3":
                $alert_type = "alert alert-success alert-dismissable";
                $msg = "Product updated successfully";
                break;
            case "4":
                $alert_type = "alert alert-danger alert-dismissable";
                $msg = "Something went wrong , please try again.";
                break;
            case "5":
                $alert_type = "alert alert-success alert-dismissable";
                $msg = "Product deleted successfully";
                break;
        }
        ?>
        <div class="<?php echo $alert_type; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $msg; ?>
        </div>
<?php } ?>
</div>

<?php if (isset($_REQUEST['add']) || isset($_REQUEST['edit_product'])) {

 ?>
    <section class="content_in">

        <form action="" id="product_form" method="post" enctype="multipart/form-data" autocomplete="off">
            <?php if (isset($_REQUEST['edit_product'])) { ?>
                <input type="hidden" name="editId" value="<?php echo $result_edit[0]['id']; ?>" />
                <input type="hidden" name="imagename" value="<?php echo $result_edit[0]['photo']; ?>" />
    <?php } ?>
            <ul class="nav nav-tabs no-tabs" id="myTab">
                <li class="active"><a data-toggle="tab" href="#">Product Information</a></li>
            </ul>
            <div class="tab-content">
                <div id="dealinfo" class="tab-pane action_inner1 active">
                    <ul>

                        <li class="pr_pickcr">
                            <p>Profile Picture:</p>
                            <span class="img_upld single_image">
                                <?php if (isset($_REQUEST['edit_product'])) {
                                    if ($result_edit[0]['photo'] == "") {
                                        ?>
                                        <img src="template/images/user1.png" style="width: 100px; height: 100px;" />	 	
                                        <?php } if ($result_edit[0]['photo'] != "") {
                                        ?>
                                        <img style="width: 100px; height: 100px;" src="uploads/crop/<?php echo $result_edit[0]['photo']; ?>" />	 	
        <?php }
    } else { ?>
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
                        <li><p>Title:<span class="asterisk">&nbsp;*</span></p>
                            <input type="text" name="title" value="<?php if (isset($result_edit)) {
        echo $result_edit[0]['title'];
    } ?>" id="title" placeholder="Add Product Title"> </li> 
							
							
						<li><p>Description:<span class="asterisk">&nbsp;*</span></p>
						
					
				
						
                            <textarea cols="70" rows="7"  name="description" id="description"><?php if (isset($result_edit)) {
        echo $result_edit[0]['description'];
    } ?></textarea>
                        </li> 

						<div class="adjoined-bottom">
		<div class="grid-container">
			<div class="grid-width-100">
				<div id="editor">
					
				</div>
			</div>
		</div>
	</div>

                        <div class="sec_4">
                            <p></p>
                            <a href="product.php" class="next cancel" id="prev1">Cancel</a>
                            <?php if (isset($_REQUEST['edit_product'])) { ?>
                                   
        
                                <input type="submit" class="next" name="update_product" value="Update Product" />
    <?php } else { ?>
                                <input type="submit" class="next" name="add_product" value="Save Product" />
    <?php } ?>
                        </div>
                    </ul>
                    </form>
                </div>
            </div>		

    </section>	  

<?php } else { ?>


    <section class="content_in">
        <div class="sec_n0">
            <ul>
                <li><p>Product List</p></li>
                <li class="cunt"><h3>Total:<span id="totalchange"><?php echo count($result); ?></span></h3></li>
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
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Uploaded Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

    <?php
    for ($i = 0; $i < count($result); $i++) {
        ?>

                            <tr class="odd gradeX">

                                <td>
                                <img width="50" height="50" class="img-circle" src="uploads/crop/<?php echo $result[$i]['photo']; ?>">
                                  
                                </td>
                                <td><?php echo $result[$i]['title']; ?></td>
                                <td><?php echo $result[$i]['description']; ?></td>
                                <td><?php echo date('m-d-Y', strtotime($result[$i]['created_datetime'])); ?></td>
                                <td><a href="product.php?edit_product=true&id=<?php echo $result[$i]['id']; ?>">Edit &nbsp;</a>
                                	<a href="product.php?a=pdel&id=<?php echo $result[$i]['id']; ?>">Delete</a></td>

                            </tr>
    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
<?php } ?>

<?php include("template/footer.php"); ?>

<script>
            CKEDITOR.replace( 'description' );
        </script>
<script type="text/javascript">

    $(document).ready(function () {

        $(".sfile").click(function () {
            $("input[id='images']").click();
        });

        var oTable = $('#dataTables-example').dataTable({
            "bLengthChange": false,
            "oSearch": {"bSmart": false},
            bInfo: false,
            "aoColumns": [
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
            ],
            "fnDrawCallback": function (oSettings) {
                $("#totalchange").html(oSettings.fnRecordsDisplay());
                if ($('ul.pagination li').length <= 3)
                {
                    $('.dataTables_paginate').hide();
                } else
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

        $('#myInputTextField').keyup(function () {
            oTable.fnFilter($(this).val());
        })

<?php if (!isset($_REQUEST['add']) && !isset($_REQUEST['edit'])) { ?>
            oTable.fnSort([[0, 'asc']]);
<?php } ?>

        $("#product_form").validate({
            rules: {
                description: {
                    required: true,
                }
            },
            messages: {
                description: {
                    required: "Please enter Description"
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".paginate_button").click(function () {
            $('html,body').animate({scrollTop: 0}, 'slow', function () {});
        });
    });
</script>

<script src="https://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<script type="text/javascript" src="template/js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="template/js/script.js"></script>