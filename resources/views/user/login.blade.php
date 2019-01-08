<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link href="https://fonts.googleapis.com/css?family=Oswald:300,400|Roboto:100,300,400,500,700,900" rel="stylesheet"> -->

	<link rel="shortcut icon" type="image/png" href="{{ asset('user/img/pl_tutorial.png') }}"/>
	<link rel="shortcut icon" type="image/png" href="{{ asset('user/img/pl_tutorial.png') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/responsive.css') }}">
</head>
<body>

<div class="login_page">
	<div class="container h-100">
		<div class="row h-100 justify-content-center align-items-center text-center">
			<div class="col-lg-5 col-xl-4 col-md-7 col-sm-10">
				<div class="login_form">
					<div class="header_text">
						<h1>Sign In</h1>
					</div>
					@include('includes.messages')
					<form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
						<div class="field">
							<input type="text" name="email" value="{{ old('email') }}" id="username" placeholder="E-mail" required="">
						</div>
						<div class="field">
							<input type="password" name="password" id="password" placeholder="password" required="">
						</div>
						<div class="field text-left">
							<div class="custom-control custom-checkbox my-1 mr-sm-2">
							    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="custom-control-input" id="customControlInline">
							    <label class="custom-control-label" for="customControlInline">Remember me</label>
							  </div>
						</div>
						<input type="submit" name="submit" value="Login">
					</form>

					<span><a href="{{ route('password.request') }}">Forgot your password !</a></span>
					<span>Not have an account !  <a href="{{ route('register') }}"> register here.</a></span>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="{{ asset('user/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/main.js') }}"></script>



</body>
</html>
