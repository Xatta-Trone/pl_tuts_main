@extends('admin.app')

@section('page_title','Post edit')
@section('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('admin_res\summernote\dist\summernote.css') }}">
@endsection
@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Edit Post
      </h1>
      <a href="{{ route('posts.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('posts.update',$post->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <label for="post_title">Post Title</label>
              <input type="text" name="name" class="form-control" id="post_title" placeholder="Enter Post Title" value="{{ $post->name }}">
            </div>

            <div class="form-group">
              <label for="post_author">Author (optional)</label>
              <input type="text" name="author" class="form-control" id="post_author" placeholder="Enter  author" value="{{ $post->author }}">
            </div>

            <div class="form-group">
              <label for="dept_id">Department</label>
              <select name="department_slug" id="Department" class="form-control">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                  <option value="{{ $department->slug }}" data-department="{{ $department->id }}" {{ ($department->slug == $post->department_slug)? 'selected': '' }} >{{ $department->dept_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="levelTerm">Level Term</label>
              <select name="level_term_slug" class="form-control" id="level_term_data">
                <option value="">Select Level Term</option>
              </select>
            </div>

            <div class="form-group">
              <label for="Course">Course</label>
              <select name="course_id" class="form-control" id="course_data">
                <option value="">Select Course</option>
              </select>
            </div>

            <div class="form-group">
              <label for="link">Link</label>
              <input type="text" id="link" name="link" class="form-control" value="{{ $post->link }}">
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="1" {{ ($post->status == 1) ? 'selected':'' }}>Publish</option>
                <option value="2" {{ ($post->status == 2) ? 'selected':'' }}>Pending</option>
                <option value="3" {{ ($post->status == 3) ? 'selected':'' }}>Draft</option>
                <option value="4" {{ ($post->status == 4) ? 'selected':'' }}>Private</option>
                <option value="5" {{ ($post->status == 5) ? 'selected':'' }}>Rejected</option>
              </select>
            </div>

            <div class="form-group">
              <label for="image">Image (optional)</label>
              <input type="file" id="image" name="image">
            </div>

            <div class="form-group">
              <img src="/storage/posts/{{ $post->image }}" height="200px" width="auto">
            </div>

            <div class="form-group">
              <input type="hidden" value="{{ $post->user_id }}" name="user_id">
            </div>

            <div class="form-group">
              <input type="hidden" value="{{ $post->user_type }}" name="user_type">
            </div>
            <!-- textarea -->
            <div class="form-group">
              <label>Custom Message</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="custom_message">{{ $post->custom_message }}</textarea>
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
    //level term data on department change
    chnageLevelterm();
    function chnageLevelterm(){
      var dept_id = $('#Department').find(':selected').data("department");
      var _token = $('input[name="_token"]').val();
      //console.log(dept_id);
      //console.log(_token);

      $.ajax({
        url: '{{ route('getLevelTermDataOnly') }}',
        type: 'POST',
        data: {department_id: dept_id,_token: _token},
        success: function(data){
          //console.log(data);
          //$('#level_term_data').html(data);
           var level_term_row = "<option value=\"\">Select Level Term</option>";
           $.each(data, function(index, levelTerm) {
              level_term_row += "<option value="+levelTerm.slug+" data-levelterm="+levelTerm.id +" "+ matchData(levelTerm.slug, '{{ $post->level_term_slug }}') +" >"+ levelTerm.name+"</option>";
           });
           //console.log(level_term_row);
           $('#level_term_data').html(level_term_row);
           changeCourse();
        }
      });
    };
    //check level term with post level term slug
    function matchData(data1,data2){
      if(data1 != data2){
        return '';
      }else{
        return ' selected ';
      }
    }

    $('#Department').on('change',function(){
      var dept_id = $(this).find(':selected').data("department");
      var _token = $('input[name="_token"]').val();
      //console.log(dept_id);
      //console.log(_token);

      $.ajax({
        url: '{{ route('getleveltermbyslug') }}',
        type: 'POST',
        data: {department_id: dept_id,_token: _token},
        success: function(data){
          //console.log(data);
          $('#level_term_data').html(data);
        }
      });
      
    });


    function changeCourse(){
      var level_term_id = $('#level_term_data').find(':selected').data("levelterm");
      var department_id = $('#Department').find(':selected').data("department");
      var _token = $('input[name="_token"]').val();
      console.log(level_term_id);
      console.log(department_id);
      console.log(_token);

      $.ajax({
        url: '{{ route('getCourses') }}',
        type: 'POST',
        data: {department_id:department_id,level_term_id:level_term_id,_token: _token},
        success: function(data){
          //console.log(data);
          var course_row = "<option value=\"\">Select Course</option>";
          $.each(data, function(index, course) {
             course_row += "<option value="+ course.id +" "+ matchData(course.id, {{ $post->course_id }})   +">"+ course.course_name +"</option>";
          });
         // console.log(course_row);
          $('#course_data').html(course_row);
        }
      });
    }



    //course data on level term chnage
    $('#level_term_data').change(function(){
      var level_term_id = $(this).find(':selected').data("levelterm");
      var department_id = $('#Department').find(':selected').data("department");
      var _token = $('input[name="_token"]').val();
      //console.log(level_term_id);
      //console.log(department_id);
      //console.log(_token);

      $.ajax({
        url: '{{ route('getCourses') }}',
        type: 'POST',
        data: {department_id:department_id,level_term_id:level_term_id,_token: _token},
        success: function(data){
          //console.log(data);
          var course_row = `<option value="">Select Course</option>`;
          $.each(data, function(index, course) {
             course_row += `<option value='${course.id}'>${course.course_name}</option>`;
          });
         // console.log(course_row);
          $('#course_data').html(course_row);
        }
      });
      
    });


    $('textarea').summernote();
  });


</script>

@endsection

