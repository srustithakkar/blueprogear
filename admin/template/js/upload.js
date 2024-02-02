(function () {
	
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
							
							$.ajax({
										url: "upload.php?action=single",
										type: "POST",
										data: formdata,
										processData: false,
										contentType: false,
										success: function (res) {
											
											
											
											
											
											$("#businessPreview").load(function() {
 			 									
 			 									var width = $(this).width();
  												var height = $(this).height();
  												setTimeout(function(){ 
												var abc = $('#businessPreview').imgAreaSelect({ instance: true });
												abc.setSelection((width/2)-75, (height/2)-75, (width/2)+75, (height/2)+75, true);
												abc.setOptions({ show: true });
												abc.update();
												$('#single_x').val((width/2)-75);
												$('#single_y').val((height/2)-75);
												$('#single_w').val(150);
												$('#single_h').val(150);
																		
										},200);
  										}).attr('src','tempimage/'+res);
											
											
											$('.single_image img').attr('src','tempimage/crop/'+res);
											$('#cropdiv_bussiness').show();
											$("#single_image").val(res);
											$("#loader").hide();
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
	
	var input2 = document.getElementById("mulimages");
	input2.addEventListener("change", function (evt) {
 		var i = 0, len = this.files.length, img, reader, file;
		for ( ; i < len; i++ ) {
			file = this.files[i];
	
			if (!!file.type.match(/image.*/)) {
				
				if (formdata) {
					
					var imagesize =  file.size/1024/1024;
					if(imagesize>10)
					{	
						alert("Can't Upload-Photo must be less than 10 MB");
						return false;
					}
					
					$('#multiple_x').val('');
	    			$('#multiple_y').val('');
	    			$('#multiple_w').val('');
	    			$('#multiple_h').val('');
					formdata.append("mulimages", file);
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
							$.ajax({
										url: "upload.php?action=multiple",
										type: "POST",
										data: formdata,
										processData: false,
										contentType: false,
										success: function (res) {
											//var p = $(".uploadPreview");
											//p.attr('src','tempimage/'+res);
											
											
											
											
											$(".uploadPreview").load(function() {
  											var width = $(this).width();
  											var height = $(this).height();
  
  
										  	setTimeout(function(){ 
							
												var abc = $(".uploadPreview").imgAreaSelect({ instance: true });
												abc.setSelection((width/2)-75, (height/2)-75, (width/2)+75, (height/2)+75, true);
												abc.setOptions({ show: true });
												abc.update();
												$('#multiple_x').val((width/2)-75);
		 										$('#multiple_y').val((height/2)-75);
		 										$('#multiple_w').val(150);
		 										$('#multiple_h').val(150);
											
											},200);
  											}).attr('src', 'tempimage/'+res);
											
											
											
											
											
											
											
											
											
											
											
											
											
											
											$('#imagemaincropdiv').show();
											$("#current_image").val(res);
											$("html, body").animate({
						            									scrollTop: 0
						        										}, 600);
											
											var bstring = $("#multipleimagehidden").val();
											bstring = bstring+res+',';
											$("#multipleimagehidden").val(bstring);
											$("#loader").hide();
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
				$("#mulimages").val('');
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