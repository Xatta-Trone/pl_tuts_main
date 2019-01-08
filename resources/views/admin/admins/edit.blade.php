@extends('admin.app')

@section('page_title','Admin edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('admin_res/plugins/iCheck/all.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Admin
      </h1>
      <a href="{{ route('admins.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('admins.update',$admin->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="admin_name">Admin Name</label>
              <input type="text" name="name" class="form-control" id="admin_name" placeholder="Enter Admin Name" value="{{ (old('name')) ? old('name') : $admin->name }}">
            </div>

            <div class="form-group">
              <label for="student_id">Student Id</label>
              <input type="text" name="student_id" class="form-control" id="student_id" placeholder="Enter  student id" value="{{ (old('student_id')) ? old('student_id') : $admin->student_id }}">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" class="form-control" placeholder="email" value="{{ (old('email')) ? old('email') : $admin->email }}">
            </div>
            <div class="form-group">
              <label for="user_letter">Letter</label>
              <input type="text" id="user_letter" name="user_letter" class="form-control" placeholder="user_letter" value="{{ (old('user_letter')) ? old('user_letter') : $admin->user_letter }}">
            </div>

            <div class="form-group">
              <label for="">Assign Roles</label> <br>
              @foreach ($roles as $role)
                <label>
                  <input
                  @foreach ($admin->roles as $admin_role)
                    {{ ($admin_role->id == $role->id) ? 'checked':'' }}
                  @endforeach
                   type="checkbox" name="role[]" class="flat-red" value="{{ $role->id }}">{{ $role->name }}
                </label>
              @endforeach
            </div>

            <div class="form-group">
              <label for="">Status</label> <br>
                <label><input type="checkbox" name="status" {{ ($admin->status == 1) ? 'checked': '' }} class="flat-red" value="1">  Active  </label>
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
@endsection

@section('extra_js')
  <script src="{{ asset('admin_res/plugins/iCheck/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $(function () {
      //Flat red color scheme for iCheck
         $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
           checkboxClass: 'icheckbox_flat-green',
           radioClass   : 'iradio_flat-green'
         })
    })
  </script>

@endsection