@extends('admin.app')

@section('page_title','Course edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Course
      </h1>
      <a href="{{ route('courses.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('courses.update',$course->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="deptName">Course Name</label>
              <input type="text" name="course_name" class="form-control" id="deptName" placeholder="Enter course" value="{{ $course->course_name }}">
            </div>

            <div class="form-group">
              <label for="slug">Level Term Slug (i.e. ce101)</label>
              <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter course code" value="{{ $course->slug }}">
            </div>

            <div class="form-group">
              <label for="department_id">Department</label>
             <select name="department_id" class="form-control" id="Department" >
               <option value="">Select Department</option>
               @foreach($departments as $department)
                 <option value="{{ $department->id }}" {{ ($department->id == $course->department_id)? 'selected': '' }} data-department="{{ $department->id }}" >{{ $department->dept_name }}</option>
               @endforeach
             </select>
            </div>

            <div class="form-group">
              <label for="level_term_id">Level Term</label>
             <select name="level_term_id" class="form-control" id="level_term_data">
               <option value="">Select Level Term</option>
               @foreach($levelterms as $levelterm)
                 <option value="{{ $levelterm->id }}" {{ ($levelterm->id == $course->level_term_id)? 'selected': '' }} >{{ $levelterm->name }}</option>
               @endforeach
             </select>
            </div>

            <!-- textarea -->
            <div class="form-group">
              <label>Custom Message</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="custom_message">{{ $course->custom_message }}</textarea>
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
