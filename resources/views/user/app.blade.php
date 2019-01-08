<!DOCTYPE html>
<html>
<head>
	@include('user.partials.header')
	@section('page_title','Index')
</head>
<body>
	@include('user.partials.social')
	@include('user.partials.nav')

	@section('main_content')
		@show

	@include('user.partials.footer')


</body>
</html>
