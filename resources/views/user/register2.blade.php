@extends('user.app')

@section('page_title','Register')
@section('main_content')
	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<h3>Register</h3>
						<span></span>
						<p>Start your journey from here</p>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding grey_bg register_page">
			<div class="container">
				<div class="row">
					<div class="col-lg-7 col-xl-6 mx-auto col-md-10">
						<span>after successful verification of your credentials, the system will send you an email with your id and password. </span>
						<span>
							<strong>If you are an almumni or foreigner then please <a href="https://www.facebook.com/thepltutorials/" target="_blank">contact here</a> to open your account. - <a href="https://www.facebook.com/thepltutorials/" target="_blank">PL Tutorials</a></strong>
						</span>
						@include('includes.messages')
						@if (!empty($custom_error))
							<div class="alert alert-danger">{{ $custom_error }}</div>
						@endif


						<form id="register_form" method="POST" action="{{ route('register') }}">
							{{ csrf_field() }}
							<div class="field">
								<label for="name">Official Name [including dots also if you have in your name i.e. Md. Sayem]</label>
								<input type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Official name" class="form-control">
							</div>
							<div class="field">
								<label for="merit">Admission Test merit position</label>
								  <div class="input-group mb-2 mr-sm-2">
								    <div class="input-group-prepend">
								      <select class="custom-select" name="type">
								      	<option value="A">Archi</option>
								      	<option value="E" selected="">Engineering &amp; URP</option>
								      </select>
								    </div>
								    <input type="text" class="form-control" name="merit_position" value="{{ old('merit_position') }}" id="merit" placeholder="merit position">
								  </div>
							</div>

							<div class="field">
								<label>Hall</label>
								<select name="hall_name" class="form-control" id="hall_name" required="">
									<option value="">Select Hall</option>
									@foreach ($hall_names as $hall_name)
										<option value="{{ $hall_name->hall_name }}" >{{ $hall_name->hall_name }}</option>
									@endforeach
								</select>
							</div>

							<div class="field">
								<label for="email">Email</label>
								<input type="email" name="email" value="{{ old('email') }}" placeholder="email address" class="form-control" id="email">
								<div id="error_email"></div>
							</div>

							
							<div class="field">
								{{-- <label for="student_id">Student Id</label> --}}
								<input type="hidden" name="student_id"  id="student_id" value="{{ old('student_id') }}" placeholder="student_id" class="form-control">
							</div>

							<div class="field">
								<label class="" for="id_card">Snapshot of backside of Id card.</label>
								<span>*it will be deleted after verification.</span>
								<input type="file" name="id_card" id="id_card" class="form-control" accept="image/*">
							</div>

							<div class="field">
								<canvas id="picture" width="100%" height="200"></canvas>
							</div>

							<div class="field">
								<p id="verfication_field"></p>
							</div>

							<div class="field">
								<div id="status_field"></div>
							</div>
						

							<hr>
							<input type="submit" name="submit" id="submit" value="Register" disabled="">
						</form>


					</div>
				</div>
			</div>
		</div>
@endsection


@section('extra_js')

	<script type="text/javascript" src="{{ asset('user/js/BarcodeReader.js') }}"></script>
	<script type="text/javascript">
		var takePicture = document.querySelector("#id_card"),
		showPicture = document.createElement("img");
		Result = document.querySelector("#verfication_field");
		student_id = document.querySelector("#verfication_field");
		var canvas =document.getElementById("picture");
		var ctx = canvas.getContext("2d");
		BarcodeReader.Init();
		BarcodeReader.SetImageCallback(function(result) {
			//console.log(result);
			if(result.length > 0){
				var tempArray = [];
				for(var i = 0; i < result.length; i++) {
					//tempArray.push(result[i].Format+" : "+result[i].Value);
					//Result.innerHTML=tempArray.join("<br />");

					//Result.innerHTML='You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>';
					$('#student_id').val(result[i].Value);
					//validateData();
					if($("input[type='email']").val() != ''){
						$("#status_field").html('You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>');
						 $("input[type='submit']").removeAttr("disabled");
					}
				}
			}else{
				if(result.length === 0) {
					$('#student_id').val('');
					//validateData();
					Result.innerHTML="Decoding failed. Please try with another image";
				}
			}
		});
		BarcodeReader.PostOrientation = true;
		BarcodeReader.OrientationCallback = function(result) {
			canvas.width = result.width;
			canvas.height = result.height;
			var data = ctx.getImageData(0,0,canvas.width,canvas.height);
			for(var i = 0; i < data.data.length; i++) {
				data.data[i] = result.data[i];
			}
			ctx.putImageData(data,0,0);
		};
		BarcodeReader.SwitchLocalizationFeedback(true);
		BarcodeReader.SetLocalizationCallback(function(result) {
			ctx.beginPath();
			ctx.lineWIdth = "2";
			ctx.strokeStyle="red";
			for(var i = 0; i < result.length; i++) {
				ctx.rect(result[i].x,result[i].y,result[i].width,result[i].height); 
			}
			ctx.stroke();
		});
		if(takePicture && showPicture) {
			takePicture.onchange = function (event) {
				var files = event.target.files;
				if (files && files.length > 0) {
					file = files[0];
					try {
						var URL = window.URL || window.webkitURL;
						showPicture.onload = function(event) {
							Result.innerHTML="";
							BarcodeReader.DecodeImage(showPicture);
							URL.revokeObjectURL(showPicture.src);
						};
						showPicture.src = URL.createObjectURL(file);
					}
					catch (e) {
						try {
							var fileReader = new FileReader();
							fileReader.onload = function (event) {
								showPicture.onload = function(event) {
									Result.innerHTML="";
									BarcodeReader.DecodeImage(showPicture);
								};
								showPicture.src = event.target.result;
							};
							fileReader.readAsDataURL(file);
						}
						catch (e) {
							Result.innerHTML = "Neither createObjectURL or FileReader are supported";
						}
					}
				}
			};
		}


		$(document).ready(function() {

			validateData();
			function validateData(){
			$("input[type='text'], input[type='email']").on("keyup", function(){
			    if($(this).val() != "" && $('#hall_name').val() != "" && $("#student_id").val()!= ""){
			    	$("#status_field").html('You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>');
			        $("input[type='submit']").removeAttr("disabled");
			        //console.log('ok');
			        //console.log($("#hall_name").val());
			    } else {
			    	$("#status_field").text('');
			        $("input[type='submit']").attr("disabled", "disabled");
			        //console.log('not ok');
			        //console.log($("#hall_name").val());
			    }
			});

			$("#hall_name, #id_card").on("change", function(){
			    if($(":input").val() !="" && $('#hall_name').val() != "" && $("#student_id").val()!= ""){
			    	$("#status_field").html('You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>');
			        $("input[type='submit']").removeAttr("disabled");
			        //console.log('ok');
			        //console.log($("#hall_name").val());
			    } else {
			    	$("#status_field").text('');
			        $("input[type='submit']").attr("disabled", "disabled");
			        //console.log('not ok');
			    }
			});
		}

		$("#email").on('keyup paste',function(){
			var email = $('#email').val();
			  var _token = $('input[name="_token"]').val();
			  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  if(!filter.test(email))
			  {    
			   $('#error_email').html('<label class="text-danger">Invalid Email</label>');
			   //$('#email').addClass('has-error');
			   $("input[type='submit']").attr('disabled', 'disabled');
			  }else{
			  	//console.log(email);
			  	//console.log(_token);
			  	$.ajax({
			  	    url:"{{ route('email_available.check') }}",
			  	    method:"POST",
			  	    data:{email:email, _token:_token},
			  	    success:function(result)
			  	    {
			  	    	//console.log(result);
			  	     if(result > 0)
			  	     {
			  	      $('#error_email').html('<label class="text-danger">Email not Available</label>');
			  	      //$('#email').removeClass('has-error');
			  	      //$('#register').attr('disabled', false);
			  	     }
			  	     else
			  	     {
			  	      $('#error_email').html('<label class="text-success">Email Available</label>');
			  	      //$('#email').addClass('has-error');
			  	      $('#register').attr('disabled', 'disabled');
			  	     }
			  	    }
			  	   })
			  	  }
			  
		});

		});
	</script>
@endsection