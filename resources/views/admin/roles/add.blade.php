@extends('admin.app')

@section('page_title','Role add')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('admin_res/plugins/iCheck/all.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add Role
      </h1>
      <a href="{{ route('roles.index') }}" class="btn btn-success pull-right ">List</a>
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
        <form role="form" id="ajax_form" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="Role_name">Role Name</label>
              <input type="text" name="name" class="form-control" id="Role_name" placeholder="Enter role" value="{{ old('name') }}">
            </div>


            <div class="form-group">

              <div class="col-md-6">
                <label>Post Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'post')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>User Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'user')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Dept. Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'department')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Level Term Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'levelterm')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Course Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'course')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Software Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'software')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Book Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'book')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>FAQ Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'faq')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Testimonial Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'testimonial')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              

              <div class="col-md-6">
                <label>Admin Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'admin')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Role Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'role')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Permission Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'permission')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Utilities Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'utilities')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Userdata Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'userdata')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Activites Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'activities')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>

              <div class="col-md-6">
                <label>Contact Permission</label>
                @foreach ($permissions as $permission)
                  @if ($permission->for_w == 'contact')
                    <div><label><input type="checkbox" name="permission[]" class="flat-red" value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                  @endif
                @endforeach
              </div>


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

@section('extra_js')
  <script src="{{ asset('admin_res/plugins/iCheck/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $(function () {
      //Flat red color scheme for iCheck
         $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
           checkboxClass: 'icheckbox_flat-green',
           radioClass   : 'iradio_flat-green'
         });
    })
  </script>

@endsection
