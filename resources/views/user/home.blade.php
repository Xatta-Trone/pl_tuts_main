@extends('user.app')

@section('page_title','PL Tutorials')

@section('extra_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/owl.theme.default.min.css') }}">
@endsection


@section('main_content')
	<div class="hero_area" id="ripples">
		<div class="container h-100">
			<div class="row h-100 justify-content-center align-items-center">
				<div class="col-lg-12 text-center">
					<h2>{{ $utilities->title }}</h2>
					<div id="clock" class="clock">
						<div class="wrapper">
							<span class="time">0</span>
							<br>days
						</div>
						<span class="slash">/</span>
						<div class="wrapper">
							<span class="time">0</span> 
							<br>hours
						</div>
						<span class="slash">/</span>
						<div class="wrapper">
							<span class="time">0</span>
							 <br>minutes
							</div>
						<span class="slash">/</span>
						<div class="wrapper">
							<span class="time">0</span>
							 <br>seconds
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="error"></div>

	<div class="section_padding step_area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header_text">
						<h1>You are just 3 steps away</h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="single_step_item">
						<div class="fa_container">
							<i class="fa fa-id-card-o" aria-hidden="true"></i>
						</div>
						<h4>Student Id</h4>
						Take a snapshot of your student id. This is required to register.
					</div>
				</div>
				<div class="col-md-4">
					<div class="single_step_item">
						<div class="fa_container">
							<i class="fa fa-file-text-o" aria-hidden="true"></i>
						</div>
						<h4>The Form</h4>
						Fillup the form with your informations. Make sure everything is correct.
					</div>
				</div>
				<div class="col-md-4">
					<div class="single_step_item">
						<div class="fa_container">
							<i class="fa fa-info" aria-hidden="true"></i>
						</div>
						<h4>Credentials</h4>
						After verification the system will send you an email with your credentials.
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding count_section">
		<div class="container">
			<div class="row text-center">
				<div class="col-sm-4">
					<div class="single_count_item">
						<span><i class="fa fa-user-o" aria-hidden="true"></i></span>
						<span class="counter">{{ $users }}</span>
						Users
					</div>
				</div>
				<div class="col-sm-4">
					<div class="single_count_item">
						<span><i class="fa fa-book" aria-hidden="true"></i></span>
						<span class="counter">{{ $books }}</span>
						Books
					</div>
				</div>
				<div class="col-sm-4">
					<div class="single_count_item">
						<span><i class="fa fa-download" aria-hidden="true"></i></span>
						<span class="counter">{{ $downloads }}</span>
						Downloads
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding mini_search_area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<form action="{{ route('search') }}" class="" method="GET">
						<div class="row">
							<div class="col-lg-6">
								<input type="text" name="query" placeholder="Enter your search term" class="form-control">
							</div>
							<div class="col-lg-2 col-sm-6">
								<select name="dept" class="custom-select form-inline">
									<option value="" selected="">Select Dept.</option>
									@foreach ($departments as $department)
										<option value="{{ $department->slug }}">{{ $department->dept_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-lg-2 col-sm-6">
								<select name="l_t" class="custom-select form-inline">
									<option selected="" value="">Level Term</option>
									@foreach ($level_terms as $l_t)
										<option value="{{ $l_t->slug }}">{{ $l_t->slug }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-lg-2">
								<input type="submit" name="submit" value="Search" class="pl_btn">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding quote_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<h1>"The technical man must not be lost in his own technology. He must be able to appreciate life, and life is art, drama, music, and most importantly, people."</h1>
					<span>- Fazlur Rahman Khan (1929-1982)</span>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding user_review">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header_text">
						<h1>Feedbacks</h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="tesimonial_slides">
						
					@foreach ($testimonials as $testimonial)
						<div class="single_testimonial_item">
							<div class="user_letter"><span>{{ $testimonial->user_letter }}</span></div>
							<div class="testimonial_text">
								<p>{{ $testimonial->message }}</p>
								<h4>{{ $testimonial->name }}<span>[{{ $testimonial->dept_batch }}]</span></h4>
							</div>
						</div>
					@endforeach

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding contact_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="header_text">
						<h1>Get In Touch</h1>
					</div>
					<p>We do not have any physical address <i class="fa fa-smile-o" aria-hidden="true"></i></p>
					<p>Join our <a href="https://www.facebook.com/groups/pltutorialsbuet/" target="_blank">Facebook Group</a></p>
					<p>Email: <span>{{ $utilities->email }}</span></p>
					<div class="social_box">
						<a href="{{ $utilities->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="mailto:{{ $utilities->email }}" target="_blank"><i class="fa fa-envelope"></i></a>
						<a href="{{ $utilities->youtube }}" target="_blank"><i class="fa fa-youtube"></i></a>
					</div>
				</div>
				<div class="col-lg-6">
					@include('includes.messages')
					<form class="contact_form" action="{{ route('contact') }}" method="POST" id="contactForm">
						{{ csrf_field() }}
						<input type="text" name="name" id="name" placeholder="Your name">
						<span id="nameError" class="label label-danger"></span>
						<input type="text" name="email" id="email" placeholder="Your email">
						<span id="emailError" class="label label-danger"></span>
						<input type="text" name="subject" id="subject" placeholder="Subject">
						<textarea placeholder="Message" id="message" name="message"></textarea>
						<span id="messageError" class="label label-danger"></span>
						<input type="submit" name="submit" id="submit" value="Send Message" class="pl_btn" disabled="">
					</form>
					<div id="messageStatus"></div>
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('extra_footer')

try {
		$('#ripples').ripples({
			resolution: 600,
			dropRadius: 20, //px
			perturbance: 0.05,
		});
	}
	catch (e) {
		$('#error').show().text(e);
	};

	    					//year/month/day
		$('#clock').countdown('{{ $utilities->date_time }}').on('update.countdown', function(event) {
	  		var $this = $(this).html(event.strftime(''
					+ '<div class="wrapper"><span class="time">%-D</span><br>day%!D</div><span class="slash">/</span>'
					+ '<div class="wrapper"><span class="time">%H</span><br>hours</div><span class="slash">/</span>'
					+ '<div class="wrapper"><span class="time">%M</span><br>minutes</div><span class="slash">/</span>'
					+ '<div class="wrapper"><span class="time">%S</span><br>seconds</div>'));	
		});
	//count up
	$('.counter').counterUp();

	$('.tesimonial_slides').owlCarousel({
	    loop:true,
	    margin:10,
	    nav:false,
	    dots:true,
	    items:3,
	    autoplay:true,
	    responsiveClass:true,
    	responsive:{
        0:{
            items:1
        },
        300:{
            items:2
        },
        576:{
            items:3
        }    	
    	}
	});

@endsection


@section('extra_js')

<script type="text/javascript" src="{{ asset('user/js/jquery.ripples-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/jquery.countdown.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/jquery.counterup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		checkContact();
		function checkContact(){
			$("#name").on('keyup paste',function(){
				if($(this).val() == "" || pasteData == ""){
					$("#nameError").text('Name can not be empty');
					$("input[type='submit']").attr('disabled', 'disabled');
					//console.log('empty');
					$("input[type='submit']").attr('disabled', 'disabled');
				}else{
					$("#nameError").text('ok');
					$("input[type='submit']").removeAttr('disabled');
				}
			});
			$("#email").on('keyup paste',function(){
				//console.log($(this).val());
				var email = $(this).val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(!filter.test(email)){
					$('#emailError').text('Invalid Email');
					$("input[type='submit']").attr('disabled', 'disabled');
				}else if($(this).val() == ""){
					//console.log($(this).val());
					$('#emailError').text('Email can not be empty');
					$("input[type='submit']").attr('disabled', 'disabled');
				}else{
					$('#emailError').text('ok');
					$("input[type='submit']").removeAttr('disabled');
				}
			});
		}

		$('#submit').on('click', function(e) {
		  e.preventDefault();
		  var name = $("#name").val();
		  var email = $("#email").val();
		  var subject = $("#subject").val();
		  var message = $("#message").val();
		  var _token = $('meta[name="csrf-token"]').attr('content');
		  // console.log(name);
		  // console.log(email);
		  // console.log(subject);
		  // console.log(message);
		  // console.log(_token);

		  $.ajax({
		    url: '{{ route('saveContactSubmission') }}',
		    type: 'POST',
		    data: {_token:_token,name:name,email:email,subject:subject,message:message},
		    dataType:'json',
		    beforeSend: function(){
		    	$("#submit").val('Sending');
		    },
		    success: function(data){
		      console.log(data);
		      if(data != 0){
		      	$( '#contactForm' ).each(function(){
		      	    this.reset();
		      	    $('#nameError').hide();
		      	    $('#emailError').hide();
		      	});
		      	$("#contactForm").hide(500);
		      	$("#messageStatus").text('Message sent successfully').show(500);


		      }
		      
		    }
		  });
		  
		});

	});
</script>
@endsection