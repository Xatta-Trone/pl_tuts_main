@extends('user.app')

@section('page_title','Softwares')


@section('main_content')

	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<h3>Softwares</h3>
						<span></span>
						<p>Most of them are tested</p>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding content_section software_content">
			<div class="container">
				<div class="row">

					@if ($softwares->count() > 0)
						@foreach ($softwares as $software)
							<div class="col-lg-4 col-sm-6">
								<div class="single_content_section">
									<h1>{{ $software->name }}</h1>
									<a href="#" data-post_type="{{ $software->post_type }}" data-id="{{ $software->id }}" id="modal_switch"></a>
								</div>

							</div>
						@endforeach
					@else
						<div class="col-md-12 text-center d-flex h-100 align-items-center justify-content-center">
							<h2 class="text-muted ">No Software Found</h3>
						</div>
					@endif
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div><img src="" id="image" width="50%" height="auto"></div>
		        <div><span id="description"></span></div>
		      </div>
		      <div class="modal-footer">
		        <a href="" id="link" target="_blank" class="pl_btn">Link</a>
		      </div>
		    </div>
		  </div>
		</div>
@endsection


@section('extra_js')
<script type="text/javascript">
	$(document).on('click','#modal_switch', function(e) {
	  e.preventDefault();
	  var id = $(this).data('id');
	  var post_type = $(this).data('post_type');
	  var _token = $('meta[name="csrf-token"]').attr('content');
	  // console.log(id);
	  // console.log(post_type);
	  // console.log(_token);

	  $.ajax({
	    url: '{{ route('getSearchData') }}',
	    type: 'POST',
	    data: {id:id,_token:_token,post_type:post_type},
	    dataType:'json',
	    success: function(data){
	      //console.log(data);
	      $('.modal-title').html(data.name);
	      $('#description').html(data.custom_message);
	      $('#link').attr('href',data.link);
	      $('#link').attr({'data-id':data.id,'data-post_type': data.post_type,'data-label':data.name});
	      $('#image').attr('src','/storage/'+data.post_type+'s/'+data.image);
	      $('#exampleModalCenter').modal('show');
	    }
	  });

	  
	});

	$("#link").on('click',function(e){
		//e.preventDefault();
		console.log('ok');
		var _token = $('meta[name="csrf-token"]').attr('content');
		var causer = 'user';
		var causer_id = {{ Auth::user()->id }};
		var activity = 'downloaded';
		var model_id = $(this).data('id');
		var model = $(this).data('post_type');
		var label = $(this).data('label');
		//console.log(label);

		$.ajax({
			url: '{{ route('activitySave') }}',
			type: 'POST',
			dataType: 'json',
			data: {_token:_token,causer:causer,causer_id:causer_id,activity:activity,model:model,model_id:model_id,label:label},
			success: function(data){
				//console.log(data);
			}
		});
		


	});
</script>

@endsection