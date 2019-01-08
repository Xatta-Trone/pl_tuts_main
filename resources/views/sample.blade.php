	@foreach ($data as $dept)
		<li>{{$dept->slug}}</li>
		@if ($dept->levelterms->count() > 0)
			<ul>
				@foreach ($dept->levelterms as $lt)
					<li>{{$dept->slug}}/{{$lt->slug}}</li>
					@if ($dept->courses->count() > 0)
						<ul>
							@foreach ($dept->courses as $course)
								@if ($course->level_term_id == $lt->id)
									<li>{{$dept->slug}}/{{$lt->slug}}/{{ $course->slug }}</li>
								@endif
							@endforeach
						</ul>
					@endif
				@endforeach
			</ul>
		@endif
	@endforeach


