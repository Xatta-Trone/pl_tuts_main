@extends('admin.app')

@section('page_title','WatchList')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Watch List
      </h1>
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
                <th>AddedBy</th>
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
                <th>AddedBy</th>
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
       ajax: '{{ route('watchlist.all') }}', 
       columns: [
        { data: 'rownum', name: 'rownum' },
        { data: 'user_name', name: 'user_name' },
        { data: 'added_by', name: 'added_by' },
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      "order": [[ 0, "desc" ]]
    });


   $('#UserWatchlistDelete').on('click',function(){
     // alert('click');
   });
    
  });
</script>

@endsection