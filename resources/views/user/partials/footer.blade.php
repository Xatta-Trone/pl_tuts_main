
	<div class="mini_footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 text-sm-left text-center">
					<ul>
						<li><a href="{{ route('departments') }}">Departments</a></li>
						<li><a href="{{ route('search') }}">Advance Search</a></li>
						<li><a href="{{ route('faq') }}">FAQ</a></li>
					</ul>
				</div>
				<div class="col-sm-6 text-sm-right text-center">
					<span>&copy; all rights reserved <a href="https://www.facebook.com/thepltutorials/" target="_blank">PL Tutorials</a></span>
				</div>
			</div>
		</div>
	</div>
	<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<script type="text/javascript" src="{{ asset('user/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/smoothscroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/waypoint.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/jquery.slicknav.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/main.js') }}"></script>

@section('extra_js')
	@show

<script type="text/javascript">
	$(document).ready(function() {
		
	$('#menu').slicknav({
		label: '',
		brand: '<div class="logo"><a href="{{ route('index') }}"> <!-- <span>PL <span>Tutorials</span></span> --> <img src="{{ asset('user/img/pl_tutorial.png') }}"></a></div>',
		//duplicate: true,
		allowParentLinks: true,
		afterOpen: function(trigger){
			$('.slicknav_menu').addClass('opened');
		},
		beforeClose: function(trigger){
			$('.slicknav_menu').removeClass('opened');
		}
	});

	@section('extra_footer')
		@show
		
	});
</script>

