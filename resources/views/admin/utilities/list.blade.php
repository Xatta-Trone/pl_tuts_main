@extends('admin.app')

@section('page_title','Utilities')

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
        Utilities List
      </h1>
        @can('utilities_update')
          <a href="{{ route('utilities.edit',1) }}" class="btn btn-primary pull-right">Edit</a>
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
             <tr>
               <th>Name</th>
               <th>Link</th>
             </tr>
            </tr>
            </thead>
             <tbody>
             @foreach($utilities as $utility)
                <tr>
                  <td>Title</td>
                  <td>{{ $utility->title }}</td>
                </tr>
                <tr>
                  <td>Date time</td>
                  <td>{{ $utility->date_time }}</td>
                </tr>
                <tr>
                  <td>Facebook</td>
                  <td>{{ $utility->facebook }}</td>
                </tr>
                <tr>
                  <td>Youtube</td>
                  <td>{{ $utility->youtube }}</td>
                </tr>
                <tr>
                  <td>E-mail</td>
                  <td>{{ $utility->email }}</td>
                </tr>
                <tr>
                  <td>Messenger</td>
                  <td>{{ $utility->messenger }}</td>
                </tr>
                <tr>
                  <td>Custom text</td>
                  <td>{{ $utility->custom_message }}</td>
                </tr>
             @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
               <th>Name</th>
               <th>Link</th>
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
            <div><strong>Dept_Batch:</strong> <span id="dept_batch"></span></div>
            <div><strong>Body:</strong> <span id="body"></span></div>
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
        url: '{{ route('getTestimonialById') }}',
        type: 'POST',
        data: {id:id,_token:_token},
        dataType:'json',
        success: function(data){
          console.log(data);
          $('.modal-title').html(data.name);
          $('#dept_batch').html(data.dept_batch);
          $('#body').html(data.message);
          $('#modal-default').modal('show');
        }
      });
      
    });
    
  });
</script>

@endsection