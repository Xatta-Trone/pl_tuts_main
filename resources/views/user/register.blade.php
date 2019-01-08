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
						<span>
							<strong>We highly recommed to watch <a href="https://youtu.be/MeC42p1wuaM
" target="_blank">this video</a>.</strong>
						</span>
						<span>
							<strong>If you are from current batch then you can register here.</strong>
						</span>
						<span>
							<strong>If you are an almumni or foreigner  then please <a href="https://www.facebook.com/thepltutorials/" target="_blank">contact here</a> to open your account. - <a href="https://www.facebook.com/thepltutorials/" target="_blank">PL Tutorials</a></strong>
						</span>
						<span>after successful verification of your credentials, the system will send you an email with your id and password. </span>
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
		var takePicture=document.querySelector("#id_card"),showPicture=document.createElement("img");Result=document.querySelector("#verfication_field"),student_id=document.querySelector("#verfication_field");var canvas=document.getElementById("picture"),ctx=canvas.getContext("2d");BarcodeReader.Init(),BarcodeReader.SetImageCallback(function(e){if(e.length>0)for(var t=0;t<e.length;t++)$("#student_id").val(e[t].Value),""!=$("input[type='email']").val()&&($("#status_field").html('You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>'),$("input[type='submit']").removeAttr("disabled"));else 0===e.length&&($("#student_id").val(""),Result.innerHTML="Decoding failed. Please try with another image")}),BarcodeReader.PostOrientation=!0,BarcodeReader.OrientationCallback=function(e){canvas.width=e.width,canvas.height=e.height;for(var t=ctx.getImageData(0,0,canvas.width,canvas.height),a=0;a<t.data.length;a++)t.data[a]=e.data[a];ctx.putImageData(t,0,0)},BarcodeReader.SwitchLocalizationFeedback(!0),BarcodeReader.SetLocalizationCallback(function(e){ctx.beginPath(),ctx.lineWIdth="2",ctx.strokeStyle="red";for(var t=0;t<e.length;t++)ctx.rect(e[t].x,e[t].y,e[t].width,e[t].height);ctx.stroke()}),takePicture&&showPicture&&(takePicture.onchange=function(e){var t=e.target.files;if(t&&t.length>0){file=t[0];try{var a=window.URL||window.webkitURL;showPicture.onload=function(e){Result.innerHTML="",BarcodeReader.DecodeImage(showPicture),a.revokeObjectURL(showPicture.src)},showPicture.src=a.createObjectURL(file)}catch(e){try{var i=new FileReader;i.onload=function(e){showPicture.onload=function(e){Result.innerHTML="",BarcodeReader.DecodeImage(showPicture)},showPicture.src=e.target.result},i.readAsDataURL(file)}catch(e){Result.innerHTML="Neither createObjectURL or FileReader are supported"}}}}),$(document).ready(function(){$("input[type='text'], input[type='email']").on("keyup",function(){""!=$(this).val()&&""!=$("#hall_name").val()&&""!=$("#student_id").val()?($("#status_field").html('You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>'),$("input[type='submit']").removeAttr("disabled")):($("#status_field").text(""),$("input[type='submit']").attr("disabled","disabled"))}),$("#hall_name, #id_card").on("change",function(){""!=$(":input").val()&&""!=$("#hall_name").val()&&""!=$("#student_id").val()?($("#status_field").html('You are good to go. <i class="fa fa-smile-o" aria-hidden="true"></i>'),$("input[type='submit']").removeAttr("disabled")):($("#status_field").text(""),$("input[type='submit']").attr("disabled","disabled"))}),$("#email").on("keyup paste",function(){var e=$("#email").val(),t=$('input[name="_token"]').val();/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(e)?$.ajax({url:"{{ route('email_available.check') }}",method:"POST",data:{email:e,_token:t},success:function(e){e>0?$("#error_email").html('<label class="text-danger">Email not Available</label>'):($("#error_email").html('<label class="text-success">Email Available</label>'),$("#register").attr("disabled","disabled"))}}):($("#error_email").html('<label class="text-danger">Invalid Email</label>'),$("input[type='submit']").attr("disabled","disabled"))})});
	</script>
@endsection