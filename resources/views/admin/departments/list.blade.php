@extends('admin.app')

@section('page_title','Deparments')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Deparment List
      </h1>
      @can('department_create')
        <a href="{{ route('departments.create') }}" class="btn btn-success pull-right ">Add New</a>
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
                <th>Code</th>
                <th>Slug</th>
                <th>Image</th>
                <th>message</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             @foreach($departments as $department)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $department->dept_name }}</td>
                  <td>{{ $department->dept_code }}</td>
                  <td>{{ $department->slug }}</td>
                  <td> <img src="/storage/departments/{{ $department->image }}" height="80"> </td>
                  <td>{{ $department->custom_message }}</td>
                  <td>
                    @can('department_update')
                      <a href="{{ route('departments.edit',$department->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can('department_delete')
                      <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$department->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-{{$department->id}}" action="{{ route('departments.destroy',$department->id) }}" method="post">
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
                <th>Code</th>
                <th>Slug</th>
                <th>Image</th>
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
  $(function () {
    $('#example1').DataTable();
    
  });
</script>

@endsection