@extends('admin.app')

@section('page_title','Course add')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add Course
      </h1>
      <a href="{{ route('courses.index') }}" class="btn btn-success pull-right ">List</a>
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
        <form role="form" id="ajax_form" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="deptName">Course Name</label>
              <input type="text" name="course_name" class="form-control" id="deptName" placeholder="Enter Course name" value="{{ old('course_name') }}">
            </div>

            <div class="form-group">
              <label for="dept_slug">Course Code (i.e. ce101 eee310)</label>
              <input type="text" name="slug" class="form-control" id="dept_slug" placeholder="Enter  Course code" value="{{ old('slug') }}">
            </div>

            <div class="form-group">
              <label for="dept_id">Department</label>
              <select name="department_id" id="Department" class="form-control">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                  <option value="{{ $department->id }}" data-department="{{ $department->id }}" >{{ $department->dept_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="levelTerm">Level Term</label>
              <select name="level_term_id" class="form-control" id="level_term_data">
                <option value="">Select Level Term</option>
              </select>
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

@section('extra_js')
<script type="text/javascript">
  
  $(document).ready(function(){

    $('#Department').change(function(){
      var dept_id = $(this).find(':selected').data("department");
      var _token = $('input[name="_token"]').val();
      //console.log(dept_id);
      //console.log(_token);

      $.ajax({
        url: '{{ route('getlevelterm') }}',
        type: 'POST',
        data: {department_id: dept_id,_token: _token},
        success: function(data){
          //console.log(data);
          $('#level_term_data').html(data);
        }
      });
      
    });



  });


</script>

@endsection
