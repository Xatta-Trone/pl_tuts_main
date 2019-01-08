@extends('admin.app')

@section('page_title','Userdata add')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add Batch User data
      </h1>
      <a href="{{ route('userdata.index') }}" class="btn btn-success pull-right ">List</a>
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
        <h2>At first check if the data is ok to upload by uploading it <a href="{{ route('excell.index') }}">Here</a> Because there is no coming back when the data gets stuck while importing into database</h2>

        <!-- form start -->
        <form role="form" id="ajax_form" action="{{ route('userdata.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="file">Add Excel File</label>
             <input type="file" name="file" class="form-control" id="file">
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


