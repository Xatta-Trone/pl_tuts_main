@extends('user.app')



@section('page_title','Books')



@section('extra_css')

		<link rel="stylesheet" type="text/css" href="{{ asset('user/css/dataTables.bootstrap4.min.css') }}">

@endsection



@section('main_content')



	<div class="section_padding hero_title_section">

			<div class="container">

				<div class="row text-center">

					<div class="col-lg-12">

						<h3>Books</h3>

						<span></span>

						<p>search your book from here</p>

					</div>

				</div>

			</div>

		</div>



		<div class="section_padding books_section">

			<div class="container">

				<div class="row">

					<div class="col-lg-12">

						<table id="example" class="table table-striped table-bordered" style="width:100%">

						        <thead>

						            <tr>

						                <th>Serial</th>

						                {{-- <th>Cover</th> --}}

						                <th>Book Name</th>

						                <th>Author</th>

						                <th>Link</th>

						            </tr>

						        </thead>

						        <tbody>



						            @if ($books->count() > 0)

						            	@foreach ($books as $book)

						            		<tr>

								                <td>{{ $loop->index + 1}}</td>

								                {{-- <td> @if ($book->image != '')

								                	<img src="{{ URL::to('/') }}/storage/{{$book->post_type.'s'}}/{{ $book->image }}" style="max-width: 50px; height: auto;">

								               		 @endif

								                </td> --}}

								                <td>{{ $book->name }}</td>

								                <td>{{ $book->author }}</td>

								                <td><a href="{{ $book->link }}" target="_blank" data-id="{{ $book->id }}" data-post_type="{{ $book->post_type }}" class="pl_btn saveData" data-label="{{ $book->name }}">download</a></td>

								            </tr>

						            	@endforeach

						            @else

						            	<tr>

							                <td colspan="4">Currently there is no book in our database.</td>

							            </tr>

						            @endif



						        </tbody>

						        <tfoot>

						            <tr>

						                <th>Serial</th>

						                {{-- <th>Cover</th> --}}

						                <th>Book Name</th>

						                <th>Author</th>

						                <th>Link</th>

						            </tr>

						        </tfoot>

						    </table>



					</div>

				</div>

			</div>

		</div>



@endsection



@section('extra_js')

	<script type="text/javascript" src="{{ asset('user/js/jquery.dataTables.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('user/js/dataTables.bootstrap4.min.js') }}"></script>

	<script type="text/javascript">

		

		//datatabls 



		$('#example').DataTable();





	$(".saveData").on('click',function(e){

		//e.preventDefault();

		console.log('ok');

		var _token = $('meta[name="csrf-token"]').attr('content');

		var causer = 'user';

		var causer_id = {{ Auth::check() ? Auth::user()->id : 0 }};

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

				//console.log(data);

			}

		});

		





	});

	</script>

@endsection





