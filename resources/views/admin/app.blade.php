<!DOCTYPE html>
<html>
<head>
 	@include('admin.partials.header')
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a target="_blank" href="{{ route('index') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PL</b>Tutorials</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
	 @include('admin.partials.nav')
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
	 @include('admin.partials.sidebar')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	@section('main_content')
  		@show

    <div class="modal fade" id="userLocationModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#ip_address" aria-controls="ip_address" role="tab" data-toggle="tab">Ip</a></li>
                <li role="presentation"><a href="#downloadHistory" aria-controls="downloadHistory" role="tab" data-toggle="tab">DownloadHistory</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="ip_address">
                   <table id="userIpHistory" class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr>
                       <th>Date</th>
                       <th>Ip</th>
                       <th>Location</th>
                       <th>ISP</th>
                       <th>Device</th>
                     </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                     <tr>
                       <th>Date</th>
                       <th>Ip</th>
                       <th>Location</th>
                       <th>ISP</th>
                       <th>Device</th>
                     </tr>
                    </tr>
                    </tfoot>
                  </table>


                </div>
                <div role="tabpanel" class="tab-pane" id="downloadHistory">
                  
                   <table id="userDownloadHistory" class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr>
                       <th>#</th>
                       <th>Date</th>
                       <th>Activity</th>
                       <th>Label</th>
                     </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                     <tr>
                       <th>#</th>
                       <th>Date</th>
                       <th>Activity</th>
                       <th>Label</th>
                     </tr>
                    </tr>
                    </tfoot>
                  </table>

                </div>
              </div>

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
  </div>
  <!-- /.content-wrapper -->

	@include('admin.partials.footer')




</body>
</html>
