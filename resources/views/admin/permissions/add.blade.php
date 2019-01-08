@extends('admin.app')

@section('page_title','Permissions add')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add Permission
      </h1>
      <a href="{{ route('permissions.index') }}" class="btn btn-success pull-right ">List</a>
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
        <form role="form" id="ajax_form" action="{{ route('permissions.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="permission_name">Permission Name</label>
              <input type="text" name="name" class="form-control" id="permission_name" placeholder="Enter Permission" value="{{ old('name') }}">
            </div>

            <div class="form-group">
              <label for="permission">Permission for</label>
              <select name="for_w" class="form-control">
                <option value="">Permission for</option>
                <option value="user">User</option>
                <option value="post">Post</option>
                <option value="department">Department</option>
                <option value="levelterm">LevelTerm</option>
                <option value="course">Course</option>
                <option value="software">Software</option>
                <option value="book">Book</option>
                <option value="faq">FAQ</option>
                <option value="testimonial">Testimonial</option>
                <option value="contact">Contact</option>
                <option value="userdata">UserData</option>
                <option value="admin">Admin</option>
                <option value="role">Role</option>
                <option value="permission">Permission</option>
                <option value="utilities">Utilities</option>
                <option value="activities">Activities</option>
              </select>
            </div>

          <div class="box-footer">
            <button type="submit" id="add_data" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
      <!-- /.box -->

      

    </section>
    <!-- /.content -->
@endsection


