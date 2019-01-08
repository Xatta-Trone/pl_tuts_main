@extends('admin.app')

@section('page_title','Activity edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit testimonial
      </h1>
      <a href="{{ route('testimonials.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('testimonials.update',$testimonial->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="test_title">Testimonial Title</label>
              <input type="text" name="name" class="form-control" id="test_title" placeholder="Enter Testimonial Title" value="{{ $testimonial->name }}">
            </div>

            <div class="form-group">
              <label for="user_letter">User Letter</label>
              <input type="text" name="user_letter" class="form-control" id="user_letter" placeholder="Enter User Letter" value="{{ $testimonial->user_letter }}">
            </div>

            <div class="form-group">
              <label for="dept_batch">Dept. Batch</label>
              <input type="text" name="dept_batch" class="form-control" id="dept_batch" placeholder="Enter Dept. Batch" value="{{ $testimonial->dept_batch }}">
            </div>

            <!-- textarea -->
            <div class="form-group">
              <label>Testimonial data</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="message">{{ $testimonial->message }}</textarea>
            </div>


            
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="1" {{ ($testimonial->status == 1) ? 'selected':'' }}>Publish</option>
                <option value="2" {{ ($testimonial->status == 2) ? 'selected':'' }}>Pending</option>
                <option value="3" {{ ($testimonial->status == 3) ? 'selected':'' }}>Draft</option>
                <option value="4" {{ ($testimonial->status == 4) ? 'selected':'' }}>Private</option>
                <option value="5" {{ ($testimonial->status == 5) ? 'selected':'' }}>Rejected</option>
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


@section('extra_js')
<script type="text/javascript" src="{{ asset('admin_res\summernote\dist\summernote.min.js') }}"></script>
<script type="text/javascript">
  
  $(document).ready(function(){
   
    //$('textarea').summernote();

  });

</script>

@endsection

