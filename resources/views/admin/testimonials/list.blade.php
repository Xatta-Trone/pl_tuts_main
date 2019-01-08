@extends('admin.app')

@section('page_title','Testimonials')

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
        Testimonial List
      </h1>
      @can('testimonial_create')
        <a href="{{ route('testimonials.create') }}" class="btn btn-success pull-right ">Add New</a>
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
                <th>Dept. Batch</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             @foreach($tests as $testimonial)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $testimonial->name }}</td>
                  <td>{{ $testimonial->dept_batch }}</td>
                  <td> {!! $testimonial->status($testimonial->id)  !!} </td>
                  <td>
                    <a href="#" class="btn btn-primary" id="modal_switch" data-id={{ $testimonial->id }}><i class="fa fa-eye"></i></a>
                    @can('testimonial_update')
                      <a href="{{ route('testimonials.edit',$testimonial->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can('testimonial_delete')
                      <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$testimonial->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-{{$testimonial->id}}" action="{{ route('testimonials.destroy',$testimonial->id) }}" method="post">
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
                <th>Dept. Batch</th>
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