<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link href="https://fonts.googleapis.com/css?family=Oswald:300,400|Roboto:100,300,400,500,700,900" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/responsive.css') }}">
</head>
<body>

<div class="login_page">
	<div class="container h-100">
		<div class="row h-100 justify-content-center align-items-center text-center">
			<div class="col-lg-5 col-xl-4 col-md-7 col-sm-10">
				<div class="login_form">
					<div class="header_text">
						<h1>Recover</h1>
					</div>

					@if (session('status'))
					    <div class="alert alert-success">
					        {{ session('status') }}
					    </div>
					@endif
					@if ($errors->has('email'))
					    <span class="help-block">
					        <strong>{{ $errors->first('email') }}</strong>
					    </span>
					@endif
					<form method="POST" action="{{ route('password.email') }}">
						{{ csrf_field() }}
						<div class="field">
							<input id="email" type="email" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required>
						</div>
						<input type="submit" name="submit" value="Submit">
					</form>

					<span><a href="{{ route('login') }}">Login</a></span>
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
