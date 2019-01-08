@extends('admin.app')

@section('page_title','Posts')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@php
  use App\Http\Controllers\Admin\PostsController;
@endphp
@section('main_content')  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Post List
      </h1>
      @can('post_show')
        <a href="{{ route('posts.create') }}" class="btn btn-success pull-right ">Add New</a>
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
                <th>Department</th>
                <th>LT</th>
                <th>Course</th>
                <th>PostedBY</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Department</th>
                <th>LT</th>
                <th>Course</th>
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
    $('#example1').DataTable({
       serverSide: true,
       processing: true,
       ajax: '{{ route('posts.listdata') }}', 
       columns: [
        { data: 'rownum', name: 'rownum' },
        { data: 'name', name: 'name' },
        { data: 'department_slug', name: 'department_slug' },
        { data: 'level_term_slug', name: 'level_term_slug' },
        { data: 'courseData', name: 'courseData' },
        { data: 'uploader', name: 'uploader' },
        { data: 'status', name: 'status' },
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      "order": [[ 0, "desc" ]]
    });

    $(document).on('click','#modal_switch', function() {
      //e.preventDefault();
      var id = $(this).data('id');
      var _token = $('input[name="_token"]').val();
      console.log(id);
      console.log(_token);

      $.ajax({
        url: '{{ route('getPostById') }}',
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
          $('#image').attr('src','/storage/posts/'+data.image);
          $('#modal-default').modal('show');
        }
      });
      
    });
    
  });
</script>

@endsection