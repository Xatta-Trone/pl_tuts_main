  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2016-{{ \Carbon\Carbon::now()->year}} <a href="https://adminlte.io">PL Tuts</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

  
<!-- jQuery 3 -->
<script src="{{ asset('admin_res/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admin_res/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin_res/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('admin_res/bower_components/raphael/raphael.min.js')}}"></script>
{{-- <script src="{{ asset('admin_res/bower_components/morris.js/morris.min.js')}}"></script> --}}
<!-- Sparkline -->
{{-- <script src="{{ asset('admin_res/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script> --}}
<!-- jvectormap -->
{{-- <script src="{{ asset('admin_res/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script> --}}
{{-- <script src="{{ asset('admin_res/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
<!-- jQuery Knob Chart -->
{{-- <script src="{{ asset('admin_res/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script> --}}
<!-- daterangepicker -->
{{-- <script src="{{ asset('admin_res/bower_components/moment/min/moment.min.js')}}"></script> --}}
{{-- <script src="{{ asset('admin_res/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script> --}}
<!-- datepicker -->
{{-- <script src="{{ asset('admin_res/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script> --}}
<!-- Bootstrap WYSIHTML5 -->
{{-- <script src="{{ asset('admin_res/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script> --}}
<!-- Slimscroll -->
<script src="{{ asset('admin_res/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('admin_res/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin_res/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('admin_res/dist/js/pages/dashboard.js')}}"></script> --}}
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('admin_res/dist/js/demo.js')}}"></script>
<script>
  $(function () {
    $(document).on('click','#userLocationModalSwitch', function() {
      //e.preventDefault();
      var id = $(this).data('id');
      var _token = $('input[name="_token"]').val();
      //console.log(id);
      //console.log(_token);


      $.ajax({
        url: '{{route('users.locationById')}}', //route('users.locationById')
        type: 'POST',
        data: {id:id,_token:_token},
        dataType:'json',
        success: function(data){
          //console.log(data);
          $.each(data.ip_lists , function(index, val) { 
            //console.log(index, val)
            $('#userIpHistory tbody').append(`
              <tr>
                  <td>${ formatAMPM(new Date(val['created_at'])) }</td>
                  <td>${val['user_ip']}</td>
                  <td>${$.parseJSON(val['location_info']).city}, ${$.parseJSON(val['location_info']).country}</td>
                  <td>${$.parseJSON(val['location_info']).isp}</td>
                  <td>${browserInfo($.parseJSON(val['browser_info']))}</td>
              </tr>
              
              `);
          });

          $.each(data.activity , function(index, val) { 
            //console.log(index, val)
            $('#downloadHistory tbody').append(`
              <tr>
                  <td>${ index+1 }</td>
                  <td>${ formatAMPM(new Date(val['created_at'])) }</td>
                  <td>${val['activity']}</td>
                  <td>${val['label']}</td>
              </tr>
              
              `);
          });
          // $('.modal-title').html(data.ip_lists[0].user.name +'('+data.ip_lists[0].user.student_id+')');
          // $('#dept_batch').html(data.dept_batch);
          // $('#body').html(data.message);
          $('#userLocationModal').modal('show');
        }
      });

      $('#userLocationModal').on('hidden.bs.modal', function () {
        //window.alert('hidden event fired!');
        $("#userIpHistory tr").remove(); 
        $("#downloadHistory tr").remove(); 
      });

      function browserInfo(browserInformation){
        var data = '<strong>';

            data+= browserInformation.browserName;
            data+= '</strong> on <strong>';
            data+= browserInformation.platformName;
            data+= '</strong> From <strong>';
            data+= getDeviceType(browserInformation);
            data+= '</strong>';
        return data;
      }

      function getDeviceType(browserInformation){
        if(browserInformation.isMobile)
        {
          return 'Mobile('+browserInformation.deviceFamily+')';
        }
        else if(browserInformation.isDesktop)
        {
          return 'Desktop/Laptop';
        }
        else if(browserInformation.isTablet)
        {
          return 'Tablet('+browserInformation.deviceFamily+')';
        }
        else if(browserInformation.isBot)
        {
          return 'Bot';
        }
        else{
          return 'Unable to detect';
        }
      }




      function formatAMPM(date) {
        var day = date.getDate();
        var month = date.getMonth();
        var year = date.getFullYear();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = day+'-'+month+'-'+year+'('+ hours + ':' + minutes + ' ' + ampm+')';
        return strTime;
      }
    });
    
  });
</script>

@section('extra_js')
	@show