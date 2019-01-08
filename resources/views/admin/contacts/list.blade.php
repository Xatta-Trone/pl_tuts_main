@extends('admin.app')

@section('page_title','Contacts')

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
        Contact data List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('includes.messages')


       <div class="box">
         <div class="box-header">
           <h4>Unseen</h4>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <table id="example1" class="table table-bordered table-striped table-responsive">
             <thead>
             <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>subject</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
             </thead>
             <tbody>
              
                @foreach($contacts as $contact)
                  @if ($contact->status == 0)
                    <tr>
                      <td>{{ $loop->index +1 }}</td>
                      <td>{{ $contact->name }}</td>
                      <td>{{ $contact->email }}</td>
                      <td>{{ $contact->subject }}</td>
                      <td>{{ \Carbon\Carbon::parse($contact->created_at)->toFormattedDateString() }}</td>
                      <td>
                        <a href="#" class="btn btn-primary" id="modal_switch" data-id={{ $contact->id }}><i class="fa fa-eye"></i></a>
                        @can('contact_reply')
                          <a href="{{ route('contacts.edit',$contact->id) }}" class="btn btn-primary"><i class="fa fa-mail-forward"></i></a>
                        @endcan
                        @can('contact_delete')
                          <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$contact->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                          <form id="delete-form-{{$contact->id}}" action="{{ route('contacts.destroy',$contact->id) }}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                          </form>
                        @endcan
                      </td>
                    </tr>
                  @endif
                @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>subject</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
             </tr>
             </tfoot>
           </table>
         </div>
         <!-- /.box-body -->
       </div>
       <!-- /.box -->


       <div class="box">
         <div class="box-header">
           <h4>Seen & Not Replied</h4>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <table id="example2" class="table table-bordered table-striped table-responsive">
             <thead>
             <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>subject</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
             </thead>
             <tbody>
              @foreach($contacts as $contact)
                @if ($contact->status == 1 && $contact->replied == 0)
                  <tr>
                    <td>{{ $loop->index +1 }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->subject }}</td>
                    <td>{{ \Carbon\Carbon::parse($contact->created_at)->toFormattedDateString() }}</td>
                    <td>
                      <a href="#" class="btn btn-primary" id="modal_switch" data-id={{ $contact->id }}><i class="fa fa-eye"></i></a>
                      @can('contact_reply')
                        <a href="{{ route('contacts.edit',$contact->id) }}" class="btn btn-primary"><i class="fa fa-mail-forward"></i></a>
                      @endcan
                      @can('contact_delete')
                        <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$contact->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        <form id="delete-form-{{$contact->id}}" action="{{ route('contacts.destroy',$contact->id) }}" method="post">
                          {{csrf_field()}}
                          {{method_field('DELETE')}}
                        </form>
                      @endcan
                    </td>
                  </tr>
                @endif
              @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>subject</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
             </tr>
             </tfoot>
           </table>
         </div>
         <!-- /.box-body -->
       </div>
       <!-- /.box -->

       <div class="box">
         <div class="box-header">
           <h4>Seen & Replied</h4> 
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <table id="example2" class="table table-bordered table-striped table-responsive">
             <thead>
             <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>subject</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
             </thead>
             <tbody>
              @foreach($contacts as $contact)
                @if ($contact->replied == 1)
                  <tr>
                    <td>{{ $loop->index +1 }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->subject }}</td>
                    <td>{{ \Carbon\Carbon::parse($contact->created_at)->toFormattedDateString() }}</td>
                    <td>
                      <a href="#" class="btn btn-primary" id="modal_switch" data-id={{ $contact->id }}><i class="fa fa-eye"></i></a>
                      @can('contact_reply')
                        <a href="{{ route('contacts.edit',$contact->id) }}" class="btn btn-primary"><i class="fa fa-mail-forward"></i></a>
                      @endcan
                      @can('contact_delete')
                        <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$contact->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        <form id="delete-form-{{$contact->id}}" action="{{ route('contacts.destroy',$contact->id) }}" method="post">
                          {{csrf_field()}}
                          {{method_field('DELETE')}}
                        </form>
                      @endcan
                    </td>
                  </tr>
                @endif
              @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>subject</th>
                <th>Date</th>
                <th>Action</th>
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
    $('#example1,#example2').DataTable();

    $(document).on('click','#modal_switch', function() {
      //e.preventDefault();
      var id = $(this).data('id');
      var _token = $('input[name="_token"]').val();
      console.log(id);
      console.log(_token);

      $.ajax({
        url: '{{ route('getContactDataById') }}',
        type: 'POST',
        data: {id:id,_token:_token},
        dataType:'json',
        success: function(data){
          console.log(data);
          $('.modal-title').html(data.title);
          $('#body').html(data.body);
          $('#modal-default').modal('show');
        }
      });
      
    });
    
  });
</script>

@endsection