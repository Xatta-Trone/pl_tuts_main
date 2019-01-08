@extends('admin.app')

@section('page_title','Faq edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit faq
      </h1>
      <a href="{{ route('faqs.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('faqs.update',$faq->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="faq_title">Faq Title</label>
              <input type="text" name="title" class="form-control" id="faq_title" placeholder="Enter Faq Title" value="{{ $faq->title }}">
            </div>

            
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="1" {{ ($faq->status == 1) ? 'selected':'' }}>Publish</option>
                <option value="2" {{ ($faq->status == 2) ? 'selected':'' }}>Pending</option>
                <option value="3" {{ ($faq->status == 3) ? 'selected':'' }}>Draft</option>
                <option value="4" {{ ($faq->status == 4) ? 'selected':'' }}>Private</option>
                <option value="5" {{ ($faq->status == 5) ? 'selected':'' }}>Rejected</option>
              </select>
            </div>

            <div class="form-group">
              <label>Body</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="body">{{ $faq->body }}</textarea>
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

