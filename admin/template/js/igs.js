	$( document ).ready(function() {
		$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#myTab1 a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

var h= $(".content_main").height();
$(".side_menu").css("height", h);



$("#next").click(function() {
	
	$('#myTab1 li:eq(1) a').tab('show');
  
})

$("#prev").click(function() {
	
	$('#myTab1 li:eq(0) a').tab('show');
  
})

$("#prev1").click(function() {
	
 $('#myTab > .active').prev('li').find('a').trigger('click');
  
})


$("#next1").click(function() {
	
	 $('#myTab > .active').next('li').find('a').trigger('click');
  
})



$("#other #prev1").click(function() {
	
 $('#myTab > .active').prev('li').find('a').trigger('click');
  
})

$("#milestone #next1").click(function() {
	
	 $('#myTab > .active').next('li').find('a').trigger('click');
  
})

 

// Change the selector if needed
var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

// Adjust the width of thead cells when window resizes
$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        return $(this).width();
    }).get();
    
    // Set the width of thead columns
    $table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });    
}).resize();

});


 function getPerc(myPer,container,secs,flag){
  var count=0;
  //alert(jQuery(this).find(".skillbar-title").text());
  var Ints=setInterval(function(){
    if(count < myPer){
      count++;
      if(flag)
      {
      	container.find("span").text(count);
      }
      else
      {
      	container.find("span").text(count);
      }
    }
    else
    {
      clearInterval(Ints);
    }
  } ,secs);
}



			
            
            
