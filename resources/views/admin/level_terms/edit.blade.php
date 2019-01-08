@extends('admin.app')

@section('page_title','Level term edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Level Term
      </h1>
      <a href="{{ route('levelterms.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('levelterms.update',$levelterm->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="deptName">Level Term Name</label>
              <input type="text" name="name" class="form-control" id="deptName" placeholder="Enter levelterm" value="{{ $levelterm->name }}">
            </div>

            <div class="form-group">
              <label for="slug">Level Term Slug (i.e. EEE CE)</label>
              <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter levelterm slug" value="{{ $levelterm->slug }}">
            </div>

            <div class="form-group">
              <label for="department_id">Department</label>
             <select name="department_id" class="form-control">
               <option value="">Select Department</option>
               @foreach($departments as $department)
                 <option value="{{ $department->id }}" {{ ($department->id == $levelterm->department_id)? 'selected': '' }} >{{ $department->dept_name }}</option>
               @endforeach
             </select>
            </div>

            <!-- textarea -->
            <div class="form-group">
              <label>Custom Message</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="custom_message">{{ $levelterm->custom_message }}</textarea>
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
<script type="text/javascript" src="{{ asset('admin_res\summernote\dist\summernote.min.js') }}"></script>
<script type="text/javascript">
  
  $(document).ready(function(){
    $('textarea').summernote();

  });


</script>

@endsection


