@extends('admin.app')

@section('page_title','Users add')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add User
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
        <!-- form start -->
        <form role="form" id="ajax_form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="student_name" class="form-control" id="name" placeholder="Enter name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
              <label for="student_id">Student Id</label>
              <input type="text" name="student_id" class="form-control" id="student_id" placeholder="Enter student_id" value="{{ old('student_id') }}">
              <div id="student_id_message" class="bg-info"></div>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ old('email') }}" >
              <div id="email_message" class="bg-info"></div>
            </div>


           <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="1" selected="">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <input type="submit" name="add" class="btn btn-success" value="Add">
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

    $("#student_id").on('keyup paste',function(){
        var student_id = $('#student_id').val();
        var _token = $('input[name="_token"]').val();

        //console.log(student_id);
        //console.log(_token);
        $.ajax({
            url:"{{ route('checkExistingUser') }}",
            method:"POST",
            data:{student_id:student_id, _token:_token},
            success:function(result)
            {
            //console.log(result);
             var message = result.exists+' & '+result.registerd;
             $('#student_id_message').html(message);
             
            }
           })
      });


    $("#email").on('keyup paste',function(){
      var email = $('#email').val();
        var _token = $('input[name="_token"]').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!filter.test(email))
        {    
         $('#email_message').html('<label class="text-danger">Invalid Email</label>');
         //$('#email').addClass('has-error');
         //$("input[type='submit']").attr('disabled', 'disabled');
        }else{
          //console.log(email);
          //console.log(_token);
          $.ajax({
              url:"{{ route('email_available.check') }}",
              method:"POST",
              data:{email:email, _token:_token},
              success:function(result)
              {
                console.log(result);
               if(result > 0)
               {
                $('#email_message').html('<label class="text-danger">Email not Available</label>');
                //$('#email').removeClass('has-error');
                //$('#register').attr('disabled', false);
               }
               else
               {
                $('#email_message').html('<label class="text-success">Email Available</label>');
                //$('#email').addClass('has-error');
                //$("input[type='submit']").removeAttr("disabled");
               }
              }
             })
            }
        });



  });
</script>




@endsection


