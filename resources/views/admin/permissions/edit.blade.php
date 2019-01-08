@extends('admin.app')

@section('page_title','permissions edit')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Permission
      </h1>
      <a href="{{ route('permissions.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('permissions.update',$permission->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="permission_name">Permission Name</label>
              <input type="text" name="name" class="form-control" id="permission_name" placeholder="Enter permission" value="{{ $permission->name }}">
            </div>

            <div class="form-group">
              <label for="permission">Permission for</label>
              <select name="for_w" class="form-control">
                <option value="">Permission for</option>
                <option value="user" {{ ($permission->for_w == 'user') ? 'selected': '' }}>User</option>
                <option value="post" {{ ($permission->for_w == 'post') ? 'selected': '' }}>Post</option>
                <option value="department" {{ ($permission->for_w == 'department') ? 'selected': '' }}>Department</option>
                <option value="levelterm" {{ ($permission->for_w == 'levelterm') ? 'selected': '' }}>LevelTerm</option>
                <option value="course" {{ ($permission->for_w == 'course') ? 'selected': '' }}>Course</option>
                <option value="software" {{ ($permission->for_w == 'software') ? 'selected': '' }}>Software</option>
                <option value="book" {{ ($permission->for_w == 'book') ? 'selected': '' }}>Book</option>
                <option value="faq" {{ ($permission->for_w == 'faq') ? 'selected': '' }}>FAQ</option>
                <option value="testimonial" {{ ($permission->for_w == 'testimonial') ? 'selected': '' }}>Testimonial</option>
                <option value="contact" {{ ($permission->for_w == 'contact') ? 'selected': '' }}>Contact</option>
                <option value="userdata" {{ ($permission->for_w == 'userdata') ? 'selected': '' }}>UserData</option>
                <option value="admin" {{ ($permission->for_w == 'admin') ? 'selected': '' }}>Admin</option>
                <option value="role" {{ ($permission->for_w == 'role') ? 'selected': '' }}>Role</option>
                <option value="permission" {{ ($permission->for_w == 'permission') ? 'selected': '' }}>Permission</option>
                <option value="utilities" {{ ($permission->for_w == 'utilities') ? 'selected': '' }}>Utilities</option>
                <option value="activities" {{ ($permission->for_w == 'activities') ? 'selected': '' }}>Activities</option>
              </select>
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


