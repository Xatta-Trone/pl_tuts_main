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
    $('#example1').DataTable({
       serverSide: true,
       processing: true,
       ajax: '{{ route('users.listdata') }}', 
       columns: [
        { data: 'rownum', name: 'rownum' },
        { data: 'name', name: 'name' },
        { data: 'student_id', name: 'student_id' },
        { data: 'email', name: 'email' },
        { data: 'user_letter', name: 'user_letter' },
        { data: 'join_date', name: 'join_date' },
        { data: 'status', name: 'status' },
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      "order": [[ 0, "desc" ]]
    });
    
  });
</script>

@endsection