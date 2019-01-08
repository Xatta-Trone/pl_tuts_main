@extends('admin.app')

@section('page_title','Contacts edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Reply
      </h1>
      <a href="{{ route('contacts.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('contacts.update',$contact->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="from">From</label>
              <input type="text" name="from" class="form-control" id="from" placeholder="Sender" value="pltutorialsbuet@gmail.com" >
            </div>
            <div class="form-group">
              <label for="to">To</label>
              <input type="text" name="to" class="form-control" id="to" placeholder="Receiver" value="{{ $contact->email }}" readonly="" >
            </div>

            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" value="Response To :{{ $contact->subject }}" >
            </div>

            <div class="form-group">
              <label>Body</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="body"></textarea>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" id="add_data" class="btn btn-success">Send</button>
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

