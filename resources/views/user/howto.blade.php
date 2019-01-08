@extends('user.app')

@section('page_title','howto')


@section('main_content')

	
	<div class="section_padding hero_title_section">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">
					<h3>How to</h3>
					<span></span>
					<p>Learn how to register</p>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding grey_bg howto_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2>Things required to signup.</h2>
					<span>**You can read the whole page or just watch <a href="https://youtu.be/MeC42p1wuaM
" target="_blank">this video</a></span>
					<hr>
					<ol class="list">
						<li>Your official name</li>
						<li>BUET admission merit position</li>
						<li>Hall name</li>
						<li>*** Backside image of your student id (this is a must)</li>

					</ol>
					<hr>
					<span>System will check these informations and verify your identity. <br> After successful verification the system will send you an email with your <strong>login id and password</strong></span>
					<hr>
					<div class="id_description">
						<p>The backside image of your id shall be a clear picture,the spaces among the barcode lines should be clearly visible.</p>
						<hr>
						<p>The barcode line should be in horizontal direction (sample image below)</p>
						<img src="{{ asset('user/img/id/1.jpg')}}">
						<img src="{{ asset('user/img/id/2.jpg')}}">
						<hr>
						<p>Image shall not be like this (sample image below)</p>
						<img src="{{ asset('user/img/id/3.jpg')}}">
						<img src="{{ asset('user/img/id/4.jpg')}}">
					</div>
					<hr>
					<a href="{{ route('register') }}" class="pl_btn">Register</a>



				</div>
			</div>
		</div>
	</div>

@endsection