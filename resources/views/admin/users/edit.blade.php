@extends('admin.app')

@section('page_title','User edit')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit User
      </h1>
      <a href="{{ route('users.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
              <label for="student_id">Student Id</label>
              <input type="text" name="student_id" class="form-control" id="student_id" placeholder="Enter student_id" value="{{ $user->student_id }}" readonly="">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ $user->email }}" >
            </div>

            <div class="form-group">
              <label for="user_letter">User Letter</label>
              <input type="text" name="user_letter" class="form-control" id="user_letter" placeholder="Enter user_letter" value="{{ $user->user_letter }}">
            </div>


           <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="1" {{ ($user->status == 1) ? 'selected':'' }}>Active</option>
                <option value="0" {{ ($user->status == 0) ? 'selected':'' }}>Inactive</option>
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


