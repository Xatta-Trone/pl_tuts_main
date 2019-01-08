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
             @foreach($courses as $course)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $course->course_name }}</td>
                  <td>{{ $course->slug }}</td>
                  <td>{{ $course->department->dept_name }}</td>
                  <td>{{ $course->levelterm->slug }}</td>
                  <td>{{ $course->custom_message }}</td>
                  <td>
                    @can('course_update')
                      <a href="{{ route('courses.edit',$course->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can('course_delete')
                      <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$course->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-{{$course->id}}" action="{{ route('courses.destroy',$course->id) }}" method="post">
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
      $('#example1').DataTable();
      
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
