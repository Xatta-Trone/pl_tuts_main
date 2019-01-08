@extends('admin.app')

@section('page_title','Books')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('main_content')  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Book List
      </h1>
      @can('book_create')
        <a href="{{ route('books.create') }}" class="btn btn-success pull-right ">Add New</a>
      @endcan
    </section>

    <!-- Main content -->
    <section class="content">
      @include('includes.messages')


       <div class="box">
         <div class="box-header">
           
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <table id="example1" class="table table-bordered table-striped table-responsive">
             <thead>
             <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                {{-- <th>Department</th> --}}
                <th>PostedBY</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             @foreach($books as $book)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $book->name }}</td>
                  <td>{{ $book->author }}</td>
                  {{-- <td>{{ $book->department_slug }}</td> --}}
                  <td>{{ $book->uploader()->name }}</td>
                  <td> {!! $book->status($book->id)  !!} </td>
                  <td>
                    <a href="#" class="btn btn-primary" id="modal_switch" data-id={{ $book->id }}><i class="fa fa-eye"></i></a>
                    @can('book_update')
                      <a href="{{ route('books.edit',$book->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can('book_delete')
                      <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$book->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-{{$book->id}}" action="{{ route('books.destroy',$book->id) }}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                      </form>
                    @endcan

                  </td>
                </tr>
             @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                {{-- <th>Department</th> --}}
                <th>PostedBY</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </tr>
             </tfoot>
           </table>
         </div>
         <!-- /.box-body -->
       </div>
       <!-- /.box -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div><strong>Department:</strong> <span id="department"></span></div>
            <div><strong>L T:</strong> <span id="levelterm"></span></div>
            <div><strong>Author:</strong> <span id="author"></span></div>
            <div><strong>Course:</strong> <span id="course"></span></div>
            <div><strong>Posted By:</strong> <span id="user"></span></div>
            <div><strong>Link:</strong> <a href="" id="link"></a></div>
            <div><strong>Image:</strong> <img src="" id="image" width="50%" height="auto"></div>
            <div><strong>Description:</strong> <span id="description"></span></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('extra_js')
<!-- DataTables -->
<script src="{{ asset('admin_res/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_res/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable();

    $(document).on('click','#modal_switch', function() {
      //e.preventDefault();
      var id = $(this).data('id');
      var _token = $('input[name="_token"]').val();
      console.log(id);
      console.log(_token);

      $.ajax({
        url: '{{ route('getBookById') }}',
        type: 'POST',
        data: {id:id,_token:_token},
        dataType:'json',
        success: function(data){
          console.log(data);
          $('.modal-title').html(data.name);
          $('#author').html(data.author);
          $('#course').html(data.course_id);
          $('#department').html(data.department_slug);
          $('#levelterm').html(data.level_term_slug);
          $('#user').html(data.user_id);
          $('#description').html(data.custom_message);
          $('#link').attr('href',data.link);
          $('#link').html(data.link);
          $('#image').attr('src','/storage/books/'+data.image);
          $('#modal-default').modal('show');
        }
      });
      
    });
    
  });
</script>

@endsection