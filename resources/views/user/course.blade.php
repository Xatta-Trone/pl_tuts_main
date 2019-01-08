@extends('user.app')

@section('page_title',strtoupper($data->separator($data->slug)))
@section('main_content')

	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<h3>{{ $data->separator($data->slug) }}</h3>
						<span></span>
						<p>{{ $data->course_name }}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding content_section course_content">
			<div class="container">
				<div class="row">
					@if ($data->posts->count() > 0)
						@foreach ($data->posts as $post)
							@if ($post->status == 1)
								<div class="col-md-6">
									<div class="single_content_section">
										<h1>{{ $post->name }}</h1>
										<a href="{{ $post->link }}" data-id="{{ $post->id }}" data-post_type="{{ $post->post_type }}" target="_blank" data-label="{{ $post->name }}" class="saveData"></a>
									</div>
								</div>
							@endif
						@endforeach
					@else
						<div class="col-md-12 text-center d-flex h-100 align-items-center justify-content-center">
							<h2 class="text-muted ">No Material Found</h3>
						</div>
					@endif
					
					

				</div>
			</div>
		</div>
@endsection

@section('extra_js')
<script type="text/javascript">
	$(document).ready(function() {
		$(".saveData").on('click',function(e){
			//e.preventDefault();
			console.log('ok');
			var _token = $('meta[name="csrf-token"]').attr('content');
			var causer = 'user';
			var causer_id = {{ Auth::user()->id }};
			var activity = 'downloaded';
			var model_id = $(this).data('id');
			var model = $(this).data('post_type');
			var label = $(this).data('label');
			//console.log(causer_id);

			$.ajax({
				url: '{{ route('activitySave') }}',
				type: 'POST',
				dataType: 'json',
				data: {_token:_token,causer:causer,causer_id:causer_id,activity:activity,model:model,model_id:model_id,label:label},
				success: function(data){
					console.log(data);
				}
			});
			


		});
	});
</script>


@endsection