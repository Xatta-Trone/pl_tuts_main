@extends('user.app')

@section('page_title',Auth::user()->name)


@section('main_content')

	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<div class="letter_container">
							<span class="letter">{{ auth::user()->user_letter }}</span>
						</div>
						<span></span>
						<p>{{ auth::user()->name }}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding grey_bg profile_section">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">Change Password</a>
						  </li>{{-- 
						  <li class="nav-item">
						    <a class="nav-link" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Acitivity</a>
						  </li> --}}
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

								<ul class="list-group">
									<li class="list-group-item"><span>Request:</span> Please do not share the links outside of buet/non-buetians. Otherwise the system may deactivate your account.</li>
									<li class="list-group-item"><span>Name:</span> {{ auth::user()->name }}</li>
									<li class="list-group-item"><span>ID:</span> {{ auth::user()->student_id }}</li>
									<li class="list-group-item"><span>E-mail:</span> {{ auth::user()->email }}</li>
									<li class="list-group-item"><span>Joined:</span> {{ \Carbon\Carbon::parse(auth::user()->created_at)->toFormattedDateString() }}</li>
								</ul>
							</div>
					    	<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
					    		@include('includes.messages')
					    		
					    		<form method="POST">
					    			<div id="customMessage" class="col-md-6 mx-auto"></div>
					    			{{ csrf_field() }}
					    			<input type="password" name="old_password" id="old_password" placeholder="Old password">
					    			<input type="password" name="new_password" id="new_password" placeholder="New password">
					    			<input type="password" name="confirm_pass" id="confirm_pass" placeholder="Retype new password">
					    			<input type="submit" value="Change password" id="submit" disabled="">
					    		</form>
					    		


					    	</div>{{-- 
					    	<div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">

					    		<table class="table table-hover">
					    		  <thead>
					    		    <tr>
					    		      <th scope="col">#</th>
					    		      <th scope="col">Activity</th>
					    		      <th scope="col">Date</th>
					    		    </tr>
					    		  </thead>
					    		  <tbody>
									
									@if ($activities->count() > 0)
						    		  	@foreach ($activities as $activity)
							    		    <tr>
							    		      <th scope="row">{{ $loop->index + 1 }}</th>
							    		      <td>{{ $activity->activity}} <strong>{{ $activity->label}}</strong>  </td>
							    		      <td>{{\Carbon\Carbon::parse($activity->created_at)->toDayDateTimeString()}}</td>
							    		    </tr>
						    		  	@endforeach
						    		@else
						    			<tr class="text-center">
						    			  <th colspan="3">No activity found</th>
						    			</tr>
									@endif

					    		  </tbody>
					    		</table>


					    	</div> --}}
						</div>

					</div>
				</div>
			</div>
		</div>


@endsection

@section('extra_js')
<script type="text/javascript">

	

	$(document).ready(function(){
		$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});
		$("#new_password, #confirm_pass").on('keyup paste',function(){
			var old_password = $("#old_password").val();
			var new_password = $("#new_password").val();
			var confirm_pass = $("#confirm_pass").val();
			//console.log(old_password);
			//console.log(new_password.length);
			if(new_password.length <=5 ){
				$("#customMessage").html('<div class="alert alert-info">New password must be at least 6 character</div>');
			}else if(new_password == old_password){
				$("#customMessage").html('<div class="alert alert-info">New password can not be same as old password</div>');
			}else {
				$("#customMessage").html('<div class="alert alert-info">Proceed to next.</div>');
			}
		});

		$("#confirm_pass").on('keyup paste',function(){
			var old_password = $("#old_password").val();
			var new_password = $("#new_password").val();
			var confirm_pass = $("#confirm_pass").val();
			if(confirm_pass != ""){
				if(!(new_password == confirm_pass)){
					$("#customMessage").html('<div class="alert alert-info">New passwords do not match</div>');
				}else{
					$("#customMessage").html('<div class="alert alert-info">You are good to go.</div>');
					$("input[type='submit']").removeAttr('disabled');
				}
			}
		});



		//$("form").submit(function(e){
		$("#submit").on('click',function(e){
		        e.preventDefault();
		        console.log('prevented');
	        	var old_password = $("#old_password").val();
	        	var new_password = $("#new_password").val();
	        	var confirm_pass = $("#confirm_pass").val();
	        	var  _token = $('input[name="_token"]').val();

	        	// console.log(old_password);
	        	// console.log(new_password);
	        	// console.log(confirm_pass);
	        	// console.log(_token);


	        	$.ajax({
	        		url: '{{ route('customPasswordChange') }}',
	        		type: 'post',
	        		data: {old_password:old_password,_token:_token,new_password:new_password},
	        		success: function(data){
	        			console.log(data);
	        			$("#customMessage").html('<div class="alert alert-info">'+ data.message +'</div>');

	        			if(data.success == 'true'){
		        			$.ajax
				                ({
				                    type: 'POST',
				                    url: '/logout',
				                    success: function()
				                    {
				                        location.reload();
				                    }
				                });
				        }
	        		}
	        	});
	        	
		  });



	});

</script>

@endsection