@extends('admin.app')

@section('page_title','Activities')

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
        IP List
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
                <th>User</th>
                <th>Ip</th>
                <th>Location(Isp)</th>
                <th>Device</th>
                <th>Action</th>
              </tr>
             </thead>
             <tbody>

             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>User</th>
                <th>Ip</th>
                <th>Location(Isp)</th>
                <th>Device</th>
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

  
@endsection

@section('extra_js')
<!-- DataTables -->
<script src="{{ asset('admin_res/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_res/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    //$('#userIpHistory').DataTable();
    $('#example1').DataTable({
       serverSide: true,
       processing: true,
       ajax: '{{ route('users.location.listdata') }}', 
       columns: [
        { data: 'rownum', name: 'rownum' },
        { data: 'student_id', name: 'student_id' },
        { data: 'user_ip', name: 'user_ip' },
        { data: 'location_info', name: 'location_info' },
        { data: 'device_info', name: 'device_info' },
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      "order": [[ 0, "desc" ]]
    });

    // $(document).on('click','#userLocationModalSwitch', function() {
    //   //e.preventDefault();
    //   var id = $(this).data('id');
    //   var _token = $('input[name="_token"]').val();
    //   console.log(id);
    //   console.log(_token);


    //   $.ajax({
    //     url: '', //route('users.locationById')
    //     type: 'POST',
    //     data: {id:id,_token:_token},
    //     dataType:'json',
    //     success: function(data){
    //       console.log(data);
    //       $.each(data.ip_lists , function(index, val) { 
    //         //console.log(index, val)
    //         $('#userIpHistory tbody').append(`
    //           <tr>
    //               <td>${ formatAMPM(new Date(val['created_at'])) }</td>
    //               <td>${val['user_ip']}</td>
    //               <td>${$.parseJSON(val['location_info']).city}, ${$.parseJSON(val['location_info']).country}</td>
    //               <td>${$.parseJSON(val['location_info']).isp}</td>
    //               <td>${browserInfo($.parseJSON(val['browser_info']))}</td>
    //           </tr>
              
    //           `);
    //       });

    //       $.each(data.activity , function(index, val) { 
    //         //console.log(index, val)
    //         $('#downloadHistory tbody').append(`
    //           <tr>
    //               <td>${ index+1 }</td>
    //               <td>${ formatAMPM(new Date(val['created_at'])) }</td>
    //               <td>${val['activity']}</td>
    //               <td>${val['label']}</td>
    //           </tr>
              
    //           `);
    //       });
    //       // $('.modal-title').html(data[0].user.name +'('+data[0].user.student_id+')');
    //       // $('#dept_batch').html(data.dept_batch);
    //       // $('#body').html(data.message);
    //       $('#userLocationModal').modal('show');
    //     }
    //   });

    //   function browserInfo(browserInformation){
    //     var data = '<strong>';

    //         data+= browserInformation.browserName;
    //         data+= '</strong> on <strong>';
    //         data+= browserInformation.platformName;
    //         data+= '</strong> From <strong>';
    //         data+= getDeviceType(browserInformation);
    //         data+= '</strong>';
    //     return data;
    //   }

    //   function getDeviceType(browserInformation){
    //     if(browserInformation.isMobile)
    //     {
    //       return 'Mobile('+browserInformation.deviceFamily+')';
    //     }
    //     else if(browserInformation.isDesktop)
    //     {
    //       return 'Desktop/Laptop';
    //     }
    //     else if(browserInformation.isTablet)
    //     {
    //       return 'Tablet('+browserInformation.deviceFamily+')';
    //     }
    //     else if(browserInformation.isBot)
    //     {
    //       return 'Bot';
    //     }
    //     else{
    //       return 'Unable to detect';
    //     }
    //   }




    //   function formatAMPM(date) {
    //     var day = date.getDate();
    //     var month = date.getMonth();
    //     var year = date.getFullYear();
    //     var hours = date.getHours();
    //     var minutes = date.getMinutes();
    //     var ampm = hours >= 12 ? 'pm' : 'am';
    //     hours = hours % 12;
    //     hours = hours ? hours : 12; // the hour '0' should be '12'
    //     minutes = minutes < 10 ? '0'+minutes : minutes;
    //     var strTime = day+'-'+month+'-'+year+'('+ hours + ':' + minutes + ' ' + ampm+')';
    //     return strTime;
    //   }
    // });
    
  });
</script>

@endsection