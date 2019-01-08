@extends('user.app')

@section('page_title',$dept->dept_name)
@section('main_content')

	<div class="section_padding hero_title_section">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-12">

					<h3>{{ $dept->dept_name }}</h3>
					<span></span>
					<p>Bangladesh University of Engineering &amp; Technology</p>
				</div>
			</div>
		</div>
	</div>

	<div class="section_padding content_section">
		<div class="container">
			<div class="row">
				@if ($dept->levelterms->count() > 0)
					@foreach ($dept->levelterms as $level_term)
						<div class="col-md-6">
							<div class="single_content_section">
								<h1>{{ $level_term->name }}</h1>
								<a href="{{ route('singleDept',[$dept->slug,$level_term->slug]) }}"></a>
							</div>
						</div>
					@endforeach
				@else
					<div class="col-md-12 text-center d-flex h-100 align-items-center justify-content-center">
						<h2 class="text-muted ">No Level Term Found</h2>
					</div>
				@endif


			</div>
		</div>
	</div>


@endsection