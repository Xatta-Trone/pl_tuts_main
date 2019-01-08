	<title>@yield('page_title')</title>
	<link rel="shortcut icon" type="image/png" href="{{ asset('user/img/pl_tutorial.png') }}"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{!! SEO::generate() !!}

    {{-- <link href="https://fonts.googleapis.com/css?family=Audiowide|Oswald:300,400|Roboto:100,300,400,500,700,900" rel="stylesheet"> --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/slicknav.min.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="google-site-verification" content="Mymz826nHXOhX0iO-maMnE5J2dQjIGPqwTXqnqIQVgY" />
@section('extra_css')
	@show
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/responsive.css') }}">

@section('extra_header')
	@show

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-90874165-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-90874165-1');
	</script>
