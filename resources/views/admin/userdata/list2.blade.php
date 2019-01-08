@extends('admin.app')

@section('page_title','Userdatas')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Student Data List
      </h1>
      @can('userdata_import', Model::class)
       <a href="{{ route('userdata.create') }}" class="btn btn-success pull-right ">Add New</a>
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
                <th>Merit</th>
                <th>Student Id</th>
                <th>Name</th>
                <th>Hall</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             @foreach($user_datas as $userdata)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $userdata->merit }}</td>
                  <td>{{ $userdata->student_id }}</td>
                  <td>{{ $userdata->student_name }}</td>
                  <td>{{ $userdata->hall_name }}</td>
                  <td>{!! ($userdata->status == 1) ? '<span class="label label-success">Registered</span>':'<span class="label label-danger">Not Registered</span>' !!}</td>
                  <td>
                    @can('user_create')
                      @if($userdata->status == 0)
                      <a href="{{ route('userdata.edit',$userdata->id) }}" class="btn btn-primary"><i class="fa fa-user-plus"></i></a>
                      @endif
                    @endcan
                    {{-- <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$userdata->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a> --}}
                    {{-- <form id="delete-form-{{$userdata->id}}" action="{{ route('userdata.destroy',$userdata->id) }}" method="post"> --}}
                      {{-- {{csrf_field()}} --}}
                      {{-- {{method_field('DELETE')}} --}}
                    {{-- </form> --}}

                  </td>
                </tr>
             @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Merit</th>
                <th>Student Id</th>
                <th>Name</th>
                <th>Hall</th>
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