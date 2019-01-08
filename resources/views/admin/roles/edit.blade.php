@extends('admin.app')

@section('page_title','Role edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('admin_res/plugins/iCheck/all.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Role
      </h1>
      <a href="{{ route('roles.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('roles.update',$role->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="role_name">Role Name</label>
              <input type="text" name="name" class="form-control" id="role_name" placeholder="Enter role" value="{{ $role->name }}">
            </div>

            <div class="form-group">

              <div class="col-md-6">
                <label>Post Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'post')
                    <div>
                      <label>
                        <input
                          @foreach ($role->permissions as $role_permitted)
                            {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                          @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>User Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'user')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Dept. Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'department')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Level term Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'levelterm')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Course Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'course')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Software Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'software')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Book Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'book')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Faq Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'faq')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Testimonial Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'testimonial')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Admin Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'admin')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Role Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'role')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Permission Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'permission')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Utilities Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'utilities')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Userdata Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'userdata')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Activities Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'activities')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Contact Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'contact')
                    <div>
                      <label>
                        <input
                        @foreach ($role->permissions as $role_permitted)
                          {{ ($role_permitted->id == $permission->id) ? 'checked':'' }}
                        @endforeach
                         type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}
                      </label>
                    </div>
                  @endif
                @endforeach
              </div>

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


