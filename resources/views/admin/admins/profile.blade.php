@extends('admin.app')

@section('page_title',Auth::user()->name)
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('admin_res/plugins/iCheck/all.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Your Profile
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- general form elements -->
      <div class="box box-success">
        <div class="box-header with-border">
          @include('includes.messages')
          <div id="form_output"></div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" id="ajax_form" action="{{ route('admin.profileUpdate',$admin->id) }}" method="POST" >
          <div id="customMessage"></div>
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}


            <div class="form-group">
              <label for="admin_name">Admin Name</label>
              <input type="text" name="name" class="form-control" id="admin_name" placeholder="Enter Admin Name" value="{{ (old('name')) ? old('name') : $admin->name }}">
            </div>

            <div class="form-group">
              <label for="student_id">Student Id</label>
              <input type="text" readonly="" name="student_id" class="form-control" id="student_id" placeholder="Enter  student id" value="{{ (old('student_id')) ? old('student_id') : $admin->student_id }}">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" class="form-control" placeholder="email" value="{{ (old('email')) ? old('email') : $admin->email }}">
            </div>
            <div class="form-group">
              <label for="user_letter">Letter</label>
              <input type="text" id="user_letter" name="user_letter" class="form-control" placeholder="user_letter" value="{{ (old('user_letter')) ? old('user_letter') : $admin->user_letter }}">
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" id="add_data" class="btn btn-success">Update</button>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">

      <!-- general form elements -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h4>Change Password</h4>
          @include('includes.messages')
          <div id="form_output"></div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" id="ajax_form" action="{{ route('admin.profileUpdate',$admin->id) }}" method="POST" >
          <div class="box-body">

            <div id="customPassMessage"></div>
            {{ csrf_field() }}

            <div class="form-group">
              <label for="old_password">Old Password</label>
              <input type="password" name="old_password" id="old_password" placeholder="Old password" class="form-control">
            </div>

            <div class="form-group">
              <label for="new_password">New Password</label>
              <input type="password" name="new_password" id="new_password" placeholder="New password" class="form-control">
            </div>

            <div class="form-group">
              <label for="confirm_pass">Confirm New Password</label>
              <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Retype new password" class="form-control">
            </div>
            

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <input type="submit" value="Change password" id="submit" disabled="" class="btn btn-success">
          </div>
        </form>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection

@section('extra_js')
  <script src="{{ asset('admin_res/plugins/iCheck/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $(function () {
      //Flat red color scheme for iCheck
         $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
           checkboxClass: 'icheckbox_flat-green',
           radioClass   : 'iradio_flat-green'
         });
         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });

          //$("form").submit(function(e){
          $("#add_data").on('click',function(e){
                  e.preventDefault();
                  console.log('prevented');
                  var name = $("#admin_name").val();
                  var user_letter = $("#user_letter").val();
                  var email = $("#email").val();
                  var id  = {{ Auth::user()->id }};
                  var  _token = $('input[name="_token"]').val();

                  // console.log(name);
                  // console.log(email);
                  // console.log(user_letter);
                  // console.log(id);
                  // console.log(_token);


                  $.ajax({
                    url: '{{ route('admin.profileUpdate') }}',
                    type: 'post',
                    data: {name:name,_token:_token,user_letter:user_letter,email:email,id:id},
                    success: function(data){
                      //console.log(data);
                      $("#customMessage").html('<div class="alert alert-info">'+ data.message +'</div>');
                    }
                  });
                  
            });

          //password change 

          $("#new_password, #confirm_pass").on('keyup paste',function(){
            var old_password = $("#old_password").val();
            var new_password = $("#new_password").val();
            var confirm_pass = $("#confirm_pass").val();
            //console.log(old_password);
            //console.log(new_password.length);
            if(new_password.length <=5 ){
              $("#customPassMessage").html('<div class="alert alert-info">New password must be at least 6 character</div>');
            }else if(new_password == old_password){
              $("#customPassMessage").html('<div class="alert alert-info">New password can not be same as old password</div>');
            }else {
              $("#customPassMessage").html('<div class="alert alert-info">Proceed to next.</div>');
            }
          });

          $("#confirm_pass").on('keyup paste',function(){
            var old_password = $("#old_password").val();
            var new_password = $("#new_password").val();
            var confirm_pass = $("#confirm_pass").val();
            if(confirm_pass != ""){
              if(!(new_password == confirm_pass)){
                $("#customPassMessage").html('<div class="alert alert-info">New passwords do not match</div>');
              }else{
                $("#customPassMessage").html('<div class="alert alert-info">You are good to go.</div>');
                $("input[type='submit']").removeAttr('disabled');
              }
            }
          });

            $("#submit").on('click',function(e){
                e.preventDefault();
                console.log('prevented');
                var old_password = $("#old_password").val();
                var new_password = $("#new_password").val();
                var confirm_pass = $("#confirm_pass").val();
                var  _token = $('input[name="_token"]').val();
                var id = {{Auth::user()->id}};

                console.log(old_password);
                console.log(new_password);
                console.log(confirm_pass);
                console.log(_token);
                console.log(id);


                $.ajax({
                  url: '{{ route('admin.customPasswordChange') }}',
                  type: 'post',
                  data: {old_password:old_password,_token:_token,new_password:new_password,id:id},
                  success: function(data){
                    console.log(data);
                    $("#customPassMessage").html('<div class="alert alert-info">'+ data.message +'</div>');

                    if(data.success == 'true'){
                      $.ajax
                        ({
                            type: 'POST',
                            url: '/logout',
                            success: function()
                            {
                                location.reload();
                            }
                        });
                    }
                  }
                });
                    
              });
    })
  </script>

@endsection