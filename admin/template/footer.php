<!-- Core Scripts - Include with every page -->
<script src="template/js/jquery-1.10.2.js"></script>
<script src="template/js/bootstrap.min.js"></script>
<!-- jQuery Validator -->
<script src="template/js/jquery.validate.min.js"></script>
<script src="template/js/additional-methods.min.js"></script>

<script src="template/js/jquery-ui.js"></script>

<!-- Page-Level Plugin Scripts - Tables -->
<script src="template/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="template/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- <script src="https://raw.githubusercontent.com/rafaelp/css_browser_selector/master/css_browser_selector.js"></script> -->

</div>

<div id="loader" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 1000; opacity: 0.8;background: #A4A4A4;display:none;">
<div style="z-index: 1001; position: absolute; width: 550px; top: 50%; left: 50%;">	
	<img src="template/images/loaderimage.gif"/>
</div>	
</div>
 
</article>
<div style="display: none;" id="imagemaincropdiv">
<div style="width: 100%;position: absolute;" class="at_heigt">
	<div style="background: none repeat scroll 0 0 #ffb228; border: 1px solid #298EC7; display: table;margin: 0 auto;width: auto;margin-top: 104px;">
		<div class="img-crop-ttl"><h2> Crop Image</h2> </div>
		<span style="padding: 5px 90px; display:block;">
			<img id="cropbox" class="uploadPreview" style="border:1px solid #298EC7;margin: 0 auto;display: block;" src="template/images/loaderimage.gif"/><br/>
		</span>
		<span class="cr-btn">
			<input type="button"  class="next cancel" value="Cancel" onclick="close_popup_nocrop('imagemaincropdiv')">
			<input type="button"  class="crpbtn"  onclick="close_popup('imagemaincropdiv')" id="crop_btn" value="Crop Image">
		</span>	
	</div>
	
</div>
</div>	


<div style="display: none;" id="cropdiv_bussiness">
<div style="width: 100%;position: absolute;" class="at_heigt">
	
	<div style="background:#ffb228;display: table;margin: 0 auto;width: auto;margin-top: 104px;border: 1px solid #298EC7;">
		<div class="img-crop-ttl"><h2> Crop Image</h2> </div>
	   <span style="padding:5px 90px; display:block;"><img id="businessPreview" style="border:1px solid #298EC7;margin: 0 auto;display: block;" src="template/images/loaderimage.gif"/></span>	<br/>
		<span class="cr-btn">
		<input type="button" class="next cancel" value="Cancel" onclick="close_popup_nocrop('cropdiv_bussiness')">
		<input type="button" class="crpbtn" onclick="close_popup('cropdiv_bussiness')" id="crop_btn" value="Crop Image"> 
		</span>
	</div>
	
</div>
</div>	

<script type="text/javascript">
$(document).ready(function()
    {
        
        $("input:text").keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
     
				 
				  // var w = window.outerWidth;
				  // var w1 = window.innerWidth; 
				  // var pad = w-w1; 	
			 // $('#package1').on('show.bs.modal', function (e) {
				  // $("body").css("padding-right", pad+15);
			// })
			 // $('#package1').on('hidden.bs.modal', function (e) { 
				  // $("body").css("padding-right", 0);
			// })
			 // $('#package2').on('show.bs.modal', function (e) {
				  // $("body").css("padding-right", pad+15);
			// })
			 // $('#package2').on('hidden.bs.modal', function (e) { 
				  // $("body").css("padding-right", 0);
			// })
			 // $('#package3').on('show.bs.modal', function (e) {
				  // $("body").css("padding-right", pad+15);
			// })
			 // $('#package3').on('hidden.bs.modal', function (e) { 
				  // $("body").css("padding-right", 0);
			// })
        
});
</script>

<script>
$(document).ready(function () {
// $('.modal').on('show.bs.modal', function () {
// if ($(document).height() > $(window).height()) {
    // // no-scroll
    // $('body').addClass("modal-open-noscroll");
// }
// else {
    // $('body').removeClass("modal-open-noscroll");
    // }
// })
// $('.modal').on('hide.bs.modal', function () {
// $('body').removeClass("modal-open-noscroll");
    // })

 // if(navigator.userAgent.indexOf('Mac') > 0)
   // $('body').addClass('mac-os');
   
   
var OSName = "Unknown OS";
if (navigator.appVersion.indexOf("Win") != -1)
{
	$('body').addClass('win');
}
else if (navigator.appVersion.indexOf("Mac") != -1) 
{
	$('body').addClass('mac-os');
}
else if (navigator.appVersion.indexOf("X11") != -1) 
{
	$('body').addClass('unix');
}
else if (navigator.appVersion.indexOf("Linux") != -1)
{
	$('body').addClass('linux');
}
   
})
</script>

<script type="text/javascript">
// Using JQuery selectors to add onFocus and onBlur event handlers

// $(document).ready( function() {
// 
  // // Add the "focus" value to class attribute
  // $('.sub_mnx span').focusin( function() {
    // $(this).addClass('focus');
  // }
  // );
// 
  // // Remove the "focus" value to class attribute
  // $('.sub_mnx span').focusout( function() {
    // $(this).removeClass('focus');
  // }
  // );
// 
// }
// );

  </script>


</body>

</html>




