@extends('user.app')

@section('page_title','Departments')
@section('main_content')
	<div class="section_padding hero_title_section">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">
					<h3>Departments</h3>
					<span></span>
					<p>Bangladesh University of Engineering &amp; Technology</p>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding content_section">
		<div class="container">
			<div class="row">
				@if(session()->has('warning'))
				<div class="col-sm-12 d-inline-block" style="height: auto;min-height: auto!important;">
					<div class="alert-danger alert">
					  <h4>Warning!</h4>
					  {!! session('warning') !!}
					</div>
				</div>
				@endif

				@if ($departments->count() > 0)
					@foreach ($departments as $department)
						<div class="col-lg-4 col-md-6">
							<div class="single_content_section">
								<div class="content_img">
									<img src="/storage/departments/{{ $department->image }}">
								</div>
								<h1>{{ $department->slug }}</h1>
								<span>{{ $department->dept_name }}</span>
								<a href="{{ route('singleDept',$department->slug) }}"></a>
							</div>
						</div>
					@endforeach
				@else
					<div class="col-md-12 text-center d-flex h-100 align-items-center justify-content-center">
						<h2 class="text-muted ">No Department Found</h3>
					</div>
				@endif
				

			</div>
		</div>
	</div>
@endsection