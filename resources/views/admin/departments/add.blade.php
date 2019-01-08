@extends('admin.app')

@section('page_title','Department add')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add Departments
      </h1>
      <a href="{{ route('departments.index') }}" class="btn btn-success pull-right ">List</a>
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
        <form role="form" id="ajax_form" action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="deptName">Department Name</label>
              <input type="text" name="dept_name" class="form-control" id="deptName" placeholder="Enter department" value="{{ old('dept_name') }}">
            </div>

            <div class="form-group">
              <label for="dept_slug">Department Slug (i.e. EEE CE)</label>
              <input type="text" name="slug" class="form-control" id="dept_slug" placeholder="Enter department slug" value="{{ old('slug') }}">
            </div>

            <div class="form-group">
              <label for="dept_code">Department Code</label>
              <input type="text" name="dept_code" class="form-control" id="dept_code" placeholder="Enter department code" value="{{ old('dept_code') }}">
            </div>

            <div class="form-group">
              <label for="dept_image">File input</label>
              <input type="file" id="dept_image" name="image">
            </div>
            <!-- textarea -->
            <div class="form-group">
              <label>Custom Message</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="custom_message">{{ old('custom_message') }}</textarea>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" id="add_data" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
      <!-- /.box -->

      

    </section>
    <!-- /.content -->
@endsection


