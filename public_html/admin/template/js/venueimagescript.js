function setInfo(i, e) {
	$('#multiple_x').val(e.x1);
	$('#multiple_y').val(e.y1);
	$('#multiple_w').val(e.width);
	$('#multiple_h').val(e.height);
}

function show_popup(id) {
	$('#'+id).show();
}

function close_popup(id) {
	$("#loader").show();
	$('#'+id).hide();
	if(id == "cropdiv_bussiness")
	{
		var myVar=setInterval(function () {myTimer()}, 1000);
		var ias = $('#businessPreview').imgAreaSelect({ instance: true });
		ias.setOptions({ hide: true });
		ias.update();
		ajaxsinglecrop();
	}
	else
	{
		var ias = $('.uploadPreview').imgAreaSelect({ instance: true });
		ias.setOptions({ hide: true });
		ias.update();
		ajaxmultiplecrop();
	}	

}

function close_popup_nocrop(id) {

	if(id == "cropdiv_bussiness")
	{
		var myVar=setInterval(function () {myTimer()}, 1000);
		var ias = $('#businessPreview').imgAreaSelect({ instance: true });
		ias.setOptions({ hide: true });
		ias.update();
	}
	else
	{
		var ias = $('.uploadPreview').imgAreaSelect({ instance: true });
		ias.setOptions({ hide: true });
		ias.update();
		var imagename = $('#current_image').val();
		$("#imageaddmore").prepend('<li class="img_upld"><span class="cusimage img_li"><img title="'+imagename+'" src="tempimage/crop/'+imagename+'?id='+makeid()+'" style="width:100px;height:100px;"/><span class="cls_img remove">X</span></span></li>');
		
	}	
	$('#'+id).hide();
}

function ajaxsinglecrop()
{
		var x = $('#single_x').val();
	    var y = $('#single_y').val();
	    var w = $('#single_w').val();
	    var h = $('#single_h').val();
	    var imagename = $('#single_image').val();
	    $.ajax({
       				type: "GET",
        			url: "upload.php?action=crop&imagename="+imagename+"&x="+x+"&y="+y+"&w="+w+"&h="+h,
        			dataType: "html",                
        			success: function(data){
        	           $('.single_image img').attr("src","tempimage/crop/"+imagename+"?id="+makeid());		
    					$('#cropdiv_bussiness').hide();
        				$("#loader").hide();
			    	}
    	});
}


function ajaxmultiplecrop()
{
		var x = $('#multiple_x').val();
	    var y = $('#multiple_y').val();
	    var w = $('#multiple_w').val();
	    var h = $('#multiple_h').val();
	    var imagename = $('#current_image').val();
	    $.ajax({
       				type: "GET",
        			url: "upload.php?action=crop&imagename="+imagename+"&x="+x+"&y="+y+"&w="+w+"&h="+h,
        			dataType: "html",                
        			success: function(data){
        				
        				$("#imageaddmore").prepend('<li class="img_upld"><span class="cusimage img_li"><img title="'+imagename+'" src="tempimage/crop/'+imagename+'?id='+makeid()+'" style="width:100px;height:100px;"/><span class="cls_img remove">X</span></span></li>');
        				$("#loader").hide();
			    	}
    	});
}

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function myTimer() {
  $("#loader").hide();
}


$(document).ready(function() {

	var p = $(".uploadPreview");
	$('.file_input').live('change', function() {	
		var filetagid = $(this).attr("id");
		var string ='';
		var oFReader = new FileReader();
		
		if(!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test($(this).val())) {
       		alert("Invalid image file type.");
       		$(this).val('');      
        	return false;   
    	}   
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload = function (oFREvent) {
	   		p.attr('src', oFREvent.target.result);
	   		p.attr('id', filetagid);
	   		
	   		
	   		var curidstring = filetagid;
			var curimage = curidstring.split("_"); 
	   		var curimageid = 'curimage_'+curimage[1];
	   		
	   		$("#"+filetagid).parent().parent().find('.cusimage').remove();
	   		$("#"+filetagid).parent().parent().append('<span class="cusimage img_li"><img id="'+curimageid+'" src="'+oFREvent.target.result+'" style="width:100px;height:100px;"/></span>');
	   };
	    $('#imagemaincropdiv').show();

	            $("html, body").animate({
            scrollTop: 0
        }, 600);

	});
	
	$('img.uploadPreview').imgAreaSelect({
		aspectRatio: '1:1',
		onSelectEnd: setInfo
	});
	
	$(".at_heigt").height($(document).height());
	
	
	
	
	
	
	
	
});


