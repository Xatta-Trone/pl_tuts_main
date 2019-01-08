	<div class="nav_area">
		<div class="container">
			<div class="row">
				<div class="col-md-1 col-lg-2">
					<div class="logo">
						<a href="{{ route('index') }}"> <!-- <span>PL <span>Tutorials</span></span> --> <img src="{{ asset('user/img/pl_tutorial.png') }}"></a>
					</div>
				</div>
				<div class="col-md-11 col-lg-10 text-right">
					<div class="mainmenu">
						<ul id="menu">
							<li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ route('index') }}">Home</a></li>
							<li class="{{ Request::is('departments*') ? 'active' : '' }}">
								<a href="{{ route('departments') }}">Materials</a>
								<ul>
									@foreach ($data as $dept)
										<li>
											<a href="{{ route('singleDept',$dept->slug) }}">{{ $dept->slug }}</a>
											@if ($dept->levelterms->count() > 0)
												<ul>
													@foreach ($dept->levelterms as $lt)
														<li>
															<a href="{{ route('singleDept',[$dept->slug,$lt->slug]) }}">{{$lt->slug}}</a>
															@if ($dept->courses->count() > 0)
																<ul>
																	@foreach ($dept->courses as $course)
																		@if ($course->level_term_id == $lt->id)
																			<li><a href="{{ route('singleDept',[$dept->slug,$lt->slug,$course->slug]) }}">{{$course->separator($course->slug)}}</a></li>
																		@endif
																	@endforeach
																</ul>
															@endif
														</li>
													@endforeach
												</ul>
											@endif
										</li>
									@endforeach
								</ul>
							</li>
							<li class="{{ Request::is('softwares') ? 'active' : '' }}"><a href="{{ route('softwares') }}">Softwares</a></li>
							<li class="{{ Request::is('how_to') ? 'active' : '' }}"><a href="{{ route('how_to') }}">How To</a></li>
							<li class="{{ Request::is('register') || Request::is('profile') ? 'active' : '' }}">
								@if (Auth::guest())
									<a href="{{ route('profile') }}">account</a>
									<ul>
										<li><a href="{{ route('login') }}">Login</a></li>
										<li><a href="{{ route('register') }}">Register</a></li>
									</ul>
								@else
									<a href="{{ route('profile') }}">{{ auth::user()->getAcronym() }}</a>
									<ul>
										<li>
											<a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>
									</ul>
								@endif
							</li>
							<li class="{{ Request::is('books') ? 'active' : '' }}"><a href="{{ route('books') }}">Books</a></li>
							<li class="{{ Request::is('trending') ? 'active' : '' }}"><a href="{{ route('trending') }}">Trending</a></li>
							<li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
							<li class="{{ Request::is('search') ? 'active' : '' }}"><a href="{{ route('search') }}" id="search"><i class="fa fa-search"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<div id="overlay_search" class="overlay_search hidden">
		<div class="container h-100">
			<div class="row h-100 align-items-center justify-content-center">
				<div class="col-6">
					<span class="close_btn"><i class="fa fa-times"></i></span>
					<form action="{{ route('search') }}" class="" method="GET">
						<input type="text" name="query" placeholder="Search for something">
						<input type="submit" value="search">
					</form>
					<a href="{{ route('search') }}">Advance search <i class="fa fa-long-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>