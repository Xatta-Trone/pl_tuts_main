@extends('user.app')

@section('page_title','Contact')


@section('main_content')

	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<h3>Get in touch</h3>
						<span></span>
						<p>we love to hear from you.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding contact_page">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<p>We do not have any physical address <i class="fa fa-smile-o" aria-hidden="true"></i></p>
						<p>Join our <a href="https://www.facebook.com/groups/pltutorialsbuet/" target="_blank">Facebook Group</a></p>
						<p>Email: <span>pltutorialsbuet@gmail.com</span></p>
						<div class="social_box">
							<a href="{{ $utilities->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="mailto:{{ $utilities->email }}" target="_blank"><i class="fa fa-envelope"></i></a>
							<a href="{{ $utilities->youtube }}" target="_blank"><i class="fa fa-youtube"></i></a>
						</div>
					</div>
					<div class="col-lg-6">
						@include('includes.messages')
						<form class="contact_form" method="POST" id="contactForm">
							{{ csrf_field() }}
							<span>*all fields are required</span>
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
@section('extra_js')

<script type="text/javascript">
	$(document).ready(function(){
		checkContact();
		function checkContact(){
			$("#name").on('keyup paste',function(){
				console.log($(this).val());
				if($(this).val() == ""){
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
		      	$("#contactForm").hide(900);
		      	$("#messageStatus").text('Message sent successfully').show(900);


		      }
		      
		    }
		  });
		  
		});

	});
</script>
@endsection
