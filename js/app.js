$(window).load(function(){
	$(".loadingpage").hide();

	})
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	$(".m").show();
	$(".d").hide();
}else {
	$(".m").hide();
	$(".d").show();
	}

$(document).on('click', '#mainmenu a', function(event){
	$("#mainmenu").removeClass("in");
	$(".navbar-toggle").addClass("collapsed")	
	})


$(document).on('click', '#mainmenu a, .downarrow a', function(event){
    event.preventDefault();
	
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top,
		easing: "easeOut"
    }, 500);
});


$( '#fc-slideshow' ).flipshow();
$(".rotate").textrotator({
  animation: "flipUp", // You can pick the way it animates when rotating through words. Options are dissolve (default), fade, flip, flipUp, flipCube, flipCubeUp and spin.
  separator: ",", // If you don't want commas to be the separator, you can define a new separator (|, &, * etc.) by yourself using this field.
  speed: 2000 // How many milliseconds until the next word show.
});

var callback = function () {
     var h = $(window).height();
     var k = $('header').height();

     $('section').css("min-height",h);
	 $('.grid figure').css("min-height",h/2-37);
	 //$('section.hero').css("min-height",h);
	// $('.grid figure').css("min-height",h/2.2);
	 
	 $('body').scrollspy({ target: '#mainmenu' })
	 
	 var nav = jQuery('header');  
		$(window).scroll(function () {
			if ($(this).scrollTop() > h-150) {
				nav.addClass("smallnav fadeInDown");
	
			} else {
				nav.removeClass("smallnav fadeInDown");
			}
		});
		
		if ($(this).scrollTop() > h-150) {
				nav.addClass("smallnav fadeInDown");
	
			} else {
				nav.removeClass("smallnav fadeInDown");
			}
		//$(".productslistnav").find("a").height((h-k)/9);
		//$(".productslistnav").find("span").height((h-k)/9);
			
		
  };
  $(window).load(callback);
  $(window).resize(callback);



var owl = $('.productslist');
	owl.owlCarousel({
		loop:true,
		margin:0,
		nav:true,
		items:1,
		autoplay:true,
		autoplayTimeout:3000
	});
	$('.plistnext').click(function() {
		owl.trigger('next.owl.carousel');
	})
	$('.plistprev').click(function() {
		owl.trigger('prev.owl.carousel', [300]);
	})
	
	owl.on('change.owl.carousel', function( event ) {
		$(".productslist .content img").removeClass("animated rotateIn");
		$(".productslist .content h3").removeClass("animated fadeInUpBig");
		$(".productslist .content p").removeClass("animated fadeInUpBig");
	});
	owl.on('changed.owl.carousel', function( event ) {
		$(".productslist .content img").addClass("animated rotateIn");
		$(".productslist .content h3").addClass("animated fadeInUpBig");
		$(".productslist .content p").addClass("animated fadeInUpBig");
	});
	
$('.industries').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});
$('.openmodel').magnificPopup({
  type:'inline',
  midClick: true
});

$(document).on("click",".openmenu",function(){
	$(".productslistnav").addClass("opennav");
	$(this).toggleClass("openmenu closemenu");
	$(this).find("i").toggleClass("fa-arrow-right fa-arrow-left");
})
$(document).on("click",".closemenu",function(){
	$(".productslistnav").removeClass("opennav");
	$(this).toggleClass("openmenu closemenu");
	$(this).find("i").toggleClass("fa-arrow-right fa-arrow-left");
})


$('.nav-tabs-dropdown').each(function(i, elm) {
    
    $(elm).text($(elm).next('ul').find('li.active a').text());
    
});
  
$('.nav-tabs-dropdown').on('click', function(e) {

    e.preventDefault();
    
    $(e.target).toggleClass('open').next('ul').slideToggle();
    
});

$('#nav-tabs-wrapper a[data-toggle="tab"]').on('click', function(e) {

    e.preventDefault();
    
    $(e.target).closest('ul').hide().prev('a').removeClass('open').text($(this).text());
      
});
