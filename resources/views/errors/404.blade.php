<!DOCTYPE html>
<html>
<head>
	<title>oops ! Your are lost</title>
	<link rel="shortcut icon" type="image/png" href="{{ asset('user/img/pl_tutorial.png') }}"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Audiowide|Oswald:300,400|Roboto:100,300,400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('user/css/bootstrap.min.css') }}">
	<style type="text/css">
body,html{height:100%;width:100%;overflow:hidden;color:#fff;font-family:Roboto,sans-serif}.error_404_wrapper{height:100%;background-image:url(user/img/404.jpg);position:relative;background-repeat:no-repeat;background-position:center;background-attachment:fixed;background-size:cover;z-index:9999}.error_404_wrapper:before{position:absolute;left:0;top:0;width:100%;height:100%;content:'';background-color:rgba(0,0,0,.5)}.pl_btn{border:1px solid transparent;background:#61d2b4;color:#fff;padding:10px 20px;cursor:pointer;border-radius:2px;transition:.3s;text-transform:uppercase}.error_404_wrapper h2{font-size:55px}.error_404_wrapper h3{font-size:25px;color:#f8f8f8}.error_404_wrapper p{font-size:15px;padding:5px 0 10px}.error_404_wrapper a:hover{color:#fff;text-decoration:none}
	</style>
</head>
<body>
<div class="error_404_wrapper">
	<div class="container h-100">
		<div class="row h-100 justify-content-center align-items-center">
			<div class="col text-center">
				<h2>iOH HO! @{{ 404 }}</h2>
				<h3>Hey Boss !! You are an engineer! Right !</h3>
				<p>Let me get you to safety in <span id="counter">10</span>.....</p>
				<a class="pl_btn" href="{{ route('index') }}">HOME IS HERE</a>
			</div>
		</div>
	</div>
</div>

<script>
   var interval =  setInterval(function() {
        var div = document.querySelector("#counter");
        var count = div.textContent * 1 - 1;
        div.textContent = count;
        if (count <= 0) {
            div.textContent = 'redirecting';
            clearInterval(interval);
            window.location.replace("{{ route('index') }}");
        }
    }, 1000);
</script>

</body>
</html>