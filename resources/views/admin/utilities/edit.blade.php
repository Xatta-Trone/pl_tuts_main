@extends('admin.app')

@section('page_title','Utilities edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\plugins\datepicker\datepicker.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Utilities
      </h1>
      <a href="{{ route('utilities.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('utilities.update',$utility->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="test_title">Title</label>
              <input type="text" name="title" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ $utility->title }}">
            </div>

            <div class="form-group">
              <label for="test_title">Date Time</label>
              <input type="text" name="date_time" class="form-control" id="date_time" placeholder="Enter Testimonial Title" value="{{ $utility->date_time }}" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="test_title">Facebook</label>
              <input type="text" name="facebook" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ $utility->facebook }}">
            </div>
            <div class="form-group">
              <label for="test_title">Youtube</label>
              <input type="text" name="youtube" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ $utility->youtube }}">
            </div>
            <div class="form-group">
              <label for="test_title">E-mail</label>
              <input type="text" name="email" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ $utility->email }}">
            </div>
            <div class="form-group">
              <label for="test_title">Messenger</label>
              <input type="text" name="messenger" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ $utility->messenger }}">
            </div>
            <div class="form-group">
              <label>Custom message</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="custom_message">{{ $utility->custom_message }}</textarea>
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
<script type="text/javascript" src="{{ asset('admin_res\plugins\datepicker\datepicker.js') }}"></script>
<script type="text/javascript">
  
  $(document).ready(function(){
   
    //$('textarea').summernote();

    $('#date_time').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});

  });

</script>

@endsection

