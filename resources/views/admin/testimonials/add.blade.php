@extends('admin.app')

@section('page_title','Testimonial add')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add Testimonial
      </h1>
      <a href="{{ route('testimonials.index') }}" class="btn btn-success pull-right ">List</a>
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
        <form role="form" id="ajax_form" action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="test_title">Testimonial Title</label>
              <input type="text" name="name" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ old('name') }}">
            </div>

            <div class="form-group">
              <label for="user_letter">User Letter</label>
              <input type="text" name="user_letter" class="form-control" id="user_letter" placeholder="Enter User Letter" value="{{ old('user_letter') }}">
            </div>

            <div class="form-group">
              <label for="dept_batch">Dept. Batch</label>
              <input type="text" name="dept_batch" class="form-control" id="dept_batch" placeholder="Enter Dept. Batch" value="{{ old('dept_batch') }}">
            </div>



            <!-- textarea -->
            <div class="form-group">
              <label>Testimonial data</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="message">{{ old('message') }}</textarea>
            </div>


            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="1" selected="">Publish</option>
                <option value="2">Pending</option>
                <option value="3">Draft</option>
                <option value="4">Private</option>
                <option value="5">Rejected</option>
              </select>
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

@section('extra_js')
<script type="text/javascript" src="{{ asset('admin_res\summernote\dist\summernote.min.js') }}"></script>
<script type="text/javascript">
  
  $(document).ready(function(){
    $('#summernote').summernote();
  });


</script>

@endsection

