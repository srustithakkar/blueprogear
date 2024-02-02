(function () {
	
	
	$('img#businessPreview').imgAreaSelect({
			aspectRatio: '1:1',
			onSelectEnd: setInfobusiness
	});
			
	
	var _URL = window.URL || window.webkitURL;
			
	var input = document.getElementById("images"), 
		formdata = false;

	if (window.FormData) {
  		formdata = new FormData();
  		//document.getElementById("btn").style.display = "none";
	}
	
 	input.addEventListener("change", function (evt) {
 		
 		var i = 0, len = this.files.length, img, reader, file;
		for ( ; i < len; i++ ) {
			file = this.files[i];
	
			if (!!file.type.match(/image.*/)) {
				
				if (formdata) {
					//formdata.append("images[]", file);
					
					var imagesize =  file.size/1024/1024;
					if(imagesize>10)
					{	
						alert("Can't Upload-Photo must be less than 10 MB");
						return false;
					}
					
					$('#single_x').val('');
					$('#single_y').val('');
					$('#single_w').val('');
					$('#single_h').val('');
					formdata.append("images", file);
					$("#loader").show();
					
					
					var sizevalid = 0;				
					img = new Image();
	     		    img.onload = function() {
		        	 	if(this.width<150 || this.height<150)
		        		{
		        			sizevalid = 1;
		        		}
		       			
		       			if(sizevalid == 0)
		       			{
		       				$("#businessPreview").attr('src','');
							$.ajax({
										url: "upload.php?action=single",
										type: "POST",
										data: formdata,
										processData: false,
										contentType: false,
										async:false,
										success: function (res) {
											
											
											$('.single_image img').attr('src','tempimage/crop/'+res);
											$('#cropdiv_bussiness').show();
											$("#single_image").val(res);
											
											
											$("#businessPreview").load(function(){
  												var width = $(this).width();
  												var height = $(this).height();
  												setTimeout(function(){ 
														var abc = $('img#businessPreview').imgAreaSelect({ instance: true });
														abc.setSelection((width/2)-75, (height/2)-75, (width/2)+75, (height/2)+75, true);
														abc.setOptions({ show: true });
														abc.update();
												$('#single_x').val((width/2)-75);
		 										$('#single_y').val((height/2)-75);
		 										$('#single_w').val(150);
		 										$('#single_h').val(150);
		 										$("#loader").hide();
											},200);
  											}).attr('src','tempimage/'+res);
										}
									});
									
										
		        		}
		        		else
		        		{
		        			$("#loader").hide();	
		        			alert("Please choose a photo which contains at least 150 X 150 pixels.");
		        			return false;
		        		}
		        		
	        		};
	        		img.onerror = function() {
	        			$("#loader").hide();
	            		alert( "not a valid file: " + file.type);
	            		return false;
	        		};
	        		img.src = _URL.createObjectURL(file);
					
				}
			}
			else
			{
				alert("Please select valid image file");
				return false;
			}	
		}
		
	}, false);
	




	
	
}());



function setInfobusiness(i, e) {
	
	    $('#single_x').val(e.x1);
		 $('#single_y').val(e.y1);
		 $('#single_w').val(e.width);
		 $('#single_h').val(e.height);
}

function show_popup(id) {
	$('#'+id).show();
}

function myTimer() {
  $("#loader").hide();
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

function close_popup(id) {
	$("#loader").show();
	if(id == "cropdiv_bussiness")
	{
		var myVar=setInterval(function () {myTimer()}, 1000);
		var ias = $('#businessPreview').imgAreaSelect({ instance: true });
		
		ias.setOptions({ hide: true });
		ias.update();
		
		ajaxsinglecrop();
	}	

}

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function close_popup_nocrop(id) {
	$("#loader").show();
	if(id == "cropdiv_bussiness")
	{
		$('#single_x').val('');
		$('#single_y').val('');
		$('#single_w').val('');
		$('#single_h').val('');
		
					
		var myVar=setInterval(function () {myTimer()}, 1000);
		var ias = $('#businessPreview').imgAreaSelect({ instance: true });
		ias.setOptions({ hide: true });
		ias.update();
		$("#loader").hide();
	}
	$('#'+id).hide();
}


$(document).ready(function(){
$(".at_heigt").height($(document).height());
});