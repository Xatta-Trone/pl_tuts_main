@extends('user.app')

@section('page_title','Search')

@php
	use App\Http\Controllers\User\SearchController as SearchController;
@endphp

@section('main_content')

	<div class="section_padding hero_title_section">
			<div class="container">
				<div class="row text-center">
					<div class="col-lg-12">
						<h3>Search</h3>
						<span></span>
						<p>Looking for something !!</p>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding mini_search_area search_page">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<form action="{{ route('search') }}" class="" method="GET">
							<div class="row">
								<div class="col-lg-12">
									<input type="text" name="query" placeholder="Enter your search term" class="form-control">
								</div>
								<div class="col-lg-3 col-sm-6">
									<select name="dept" class="custom-select form-inline">
										<option value="" selected="">Select Dept.</option>
										@foreach ($departments as $dept)
											<option value="{{ $dept->slug }}">{{ $dept->dept_name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-lg-3 col-sm-6">
									<select name="l_t" class="custom-select form-inline">
										<option value="" selected="">Level Term</option>
										@foreach ($level_terms as $level_term)
											<option value="{{ $level_term->slug }}">{{ $level_term->slug }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-lg-3 col-sm-6">
									<select name="course" class="custom-select form-inline">
										<option value="" selected="">Course</option>
										@foreach ($courses as $course)
											<option value="{{ $course->slug }}">{{ strtoupper($course->separator($course->slug)) }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-lg-3 col-sm-6">
									<select name="content_type" class="custom-select form-inline">
										<option value="" selected="">Content Type</option>
										<option value="post">Materials</option>
										<option value="book">Books</option>
										<option value="software">Softwares</option>
									</select>
								</div>
								<div class="col-lg-12">
									<input type="submit" value="Search" class="pl_btn">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="section_padding content_section course_content search_result">
			<div class="container">
				<div class="row">
					@if (count($results) > 0)
					<div class="col">
						Showing {{($results->currentpage()-1)*$results->perpage()+1}} to {{(($results->currentpage()-1)*$results->perpage())+$results->count()}} of  {{$results->total()}} results
						<br>
						
					</div>
						@foreach ($results as $result)
							<div class="col-md-12">
								<div class="single_search_result">
									<div class="row">
										<div class="col-md-3">
											<div class="search_img" style="background-image: url({{ empty($result->image) ? URL::to('/').'/storage/nia.jpg' : URL::to('/').'/storage/'.$result->post_type.'s/'.$result->image }});"></div>
										</div>
										<div class="col-md-9">
											<h4> {{ $result->name }} <span> {{ ($result->author) ? '  by('. ($result->author).')' : ''  }}</span></h4>
											<p>{{ ($result->department_slug) ? ' Dept: '. strtoupper(($result->department_slug)) : ''  }}</p>
											<p>{{ ($result->level_term_slug) ? ' L T : '. strtoupper(($result->level_term_slug)) : ''  }}</p>
											<p>{{ ($result->course_id) ? ' Course : '. SearchController::courseSlug($result->course_id) : ''  }}</p>

											<a href="#" data-post_type="{{ $result->post_type }}" data-id="{{ $result->id }}" class="pl_btn" id="modal_switch">View</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
						<div class="col text-center">
							{!! $results->links() !!}
						</div>
					@else
						<div class="col-md-12 text-center d-flex h-100 align-items-center justify-content-center">
							<h2 class="text-muted ">No Match found</h2>
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
	      console.log(data);
	      $('.modal-title').html(data.name);
	      $('#description').html(data.custom_message);
	      $('#link').attr('href',data.link);
	      if(data.image != ""){
	      	$('#image').attr('src','/storage/'+data.post_type+'s/'+data.image);
	      }else{
	      	$('#image').attr('src','https://pl-tutorials.com/storage/nia.jpg');
	      }
	      $('#exampleModalCenter').modal('show');
	    }
	  });

	  
	});
</script>

@endsection

