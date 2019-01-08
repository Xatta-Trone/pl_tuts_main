@extends('admin.app')

@section('page_title','Users')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Users List
      </h1>
      @can('user_create')
        <a href="{{ route('users.create') }}" class="btn btn-success pull-right ">Add New</a>
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
                <th>Student Id</th>
                <th>Email</th>
                <th>Letter</th>
                <th>Joined</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             @foreach($users as $user)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->student_id }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->user_letter }}</td>
                  <td>{{ \Carbon\Carbon::parse($user->created_at)->toFormattedDateString() }}</td>
                  <td>{!! ($user->status == 1) ? '<span class="label label-success">Active</span>':'<span class="label label-danger">Not Active</span>' !!}</td>
                  <td>
                    @can('user_update')
                      <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can('user_delete')
                      <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$user->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-{{$user->id}}" action="{{ route('users.destroy',$user->id) }}" method="post">
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
                <th>Student Id</th>
                <th>Email</th>
                <th>Letter</th>
                <th>Joined</th>
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