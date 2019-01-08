$(document).ready(function(){
    					//year/month/day
	// $('#clock').countdown('2018/08/04 12:00:00').on('update.countdown', function(event) {
 //  		var $this = $(this).html(event.strftime(''
	// 			+ '<div class="wrapper"><span class="time">%-D</span><br>day%!D</div><span class="slash">/</span>'
	// 			+ '<div class="wrapper"><span class="time">%H</span><br>hours</div><span class="slash">/</span>'
	// 			+ '<div class="wrapper"><span class="time">%M</span><br>minutes</div><span class="slash">/</span>'
	// 			+ '<div class="wrapper"><span class="time">%S</span><br>seconds</div>'));	
	// });


	// //count up
	// $('.counter').counterUp({
	//             delay: 10,
	//             time: 1500
	// });

	//owl acrousel 

	// $('.tesimonial_slides').owlCarousel({
	//     loop:true,
	//     margin:10,
	//     nav:false,
	//     dots:true,
	//     items:3,
	//     autoplay:true,
	// });

	$(window).scroll(function() {
	    if ($(this).scrollTop() >= 150) {        // If page is scrolled more than 50px
	        $('#return-to-top').fadeIn(200);   // Fade in the arrow
	        $(".nav_area,.slicknav_menu").addClass("nav_fixed");
	    } else {
	        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
	        $(".nav_area,.slicknav_menu").removeClass("nav_fixed");
	    }
	});
	$('#return-to-top').click(function() {      // When arrow is clicked
	    $('body,html').animate({
	        scrollTop : 0                       // Scroll to top of body
	    }, 500);
	});

	//search 

	$('#search').on('click', function(e) {
		e.preventDefault();
		//console.log('cliked');
		$('.overlay_search').removeClass('hidden').addClass('visible');
	});

	$('.close_btn, window').on('click', function() {
		$('.overlay_search').removeClass('visible').addClass('hidden');
	});

	// $('#menu').slicknav({
	// 	label: '',
	// 	brand: '<div class="logo"><a href="index.html"> <!-- <span>PL <span>Tutorials</span></span> --> <img src="{{ asset(\'user/img/pl_tutorials.png\') }}"></a></div>',
	// 	//duplicate: false,
	// });





});

