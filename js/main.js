$(document).ready(function(){
	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
	});
	
	//Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
	

	$('#myCarousel').carousel({
	    interval: 4000
	});

	// handles the carousel thumbnails
	$('[id^=carousel-selector-]').click( function(){
	  var id_selector = $(this).attr("id");
	  var id = id_selector.substr(id_selector.length -1);
	  id = parseInt(id);
	  $('#myCarousel').carousel(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $(this).addClass('selected');
	});

	// when the carousel slides, auto update
	$('#myCarousel').on('slid', function (e) {
	  var id = $('.item.active').data('slide-number');
	  id = parseInt(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $('[id=carousel-selector-'+id+']').addClass('selected');
	});


});
