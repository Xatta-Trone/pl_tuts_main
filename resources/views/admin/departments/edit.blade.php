@extends('admin.app')

@section('page_title','Department edit')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Departments
      </h1>
      <a href="{{ route('departments.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('departments.update',$department->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="deptName">Department Name</label>
              <input type="text" name="dept_name" class="form-control" id="deptName" placeholder="Enter department" value="{{ $department->dept_name }}">
            </div>

            <div class="form-group">
              <label for="dept_slug">Department Slug (i.e. EEE CE)</label>
              <input type="text" name="slug" class="form-control" id="dept_slug" placeholder="Enter department slug" value="{{ $department->slug }}">
            </div>

            <div class="form-group">
              <label for="dept_code">Department Code</label>
              <input type="text" name="dept_code" class="form-control" id="dept_code" placeholder="Enter department code" value="{{ $department->dept_code }}">
            </div>

            <div class="form-group">
              <label for="dept_image">File input</label>
              <input type="file" id="dept_image" name="image">
            </div>

            <div class="form-group">
              <img src="/storage/departments/{{ $department->image }}" height="200px" width="auto">
            </div>
            <!-- textarea -->
            <div class="form-group">
              <label>Custom Message</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="custom_message">{{ $department->custom_message }}</textarea>
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


