@extends('admin.app')

@section('page_title','Courses')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Course List
      </h1>
      @can('course_create', Model::class)
        <a href="{{ route('courses.create') }}" class="btn btn-success pull-right ">Add New</a>
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
                <th>Name</th>
                <th>Slug</th>
                <th>Department</th>
                <th>LT</th>
                <th>message</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Department</th>
                <th>LT</th>
                <th>message</th>
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
   
@endsection

@section('extra_js')
<!-- DataTables -->
<script src="{{ asset('admin_res/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_res/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(document).ready(function(){
      $('#example1').DataTable({
         serverSide: true,
         processing: true,
         ajax: '{{ route('courses.listdata') }}', 
         columns: [
          { data: 'rownum', name: 'rownum' },
          { data: 'course_name', name: 'course_name' },
          { data: 'slug', name: 'slug' },
          { data: 'department', name: 'department' },
          { data: 'levelterm', name: 'levelterm' },
          { data: 'custom_message', name: 'custom_message' },
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, "desc" ]]
      });
      
      $('#Department').change(function(){
        var dept_id = $(this).find(':selected').data("department");
        var _token = $('input[name="_token"]').val();
        //console.log(dept_id);
        //console.log(_token);

        $.ajax({
          url: '{{ route('getlevelterm') }}',
          type: 'POST',
          data: {department_id: dept_id,_token: _token},
          success: function(data){
            //console.log(data);
            $('#level_term_data').html(data);
          }
        });
        
      });

    
    });
</script>

@endsection
