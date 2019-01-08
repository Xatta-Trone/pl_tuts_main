@extends('admin.app')

@section('page_title','Userdata edit')

@section('main_content')  

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Add New User
      </h1>
      <a href="{{ route('userdata.index') }}" class="btn btn-success pull-right ">Back</a>
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
        <form role="form" id="ajax_form" action="{{ route('userdata.update',$user->id) }}" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="form-group">
              <h4>Just enter the email of <strong>{{ $user->student_name }}</strong></h4>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ old('email') }}" >
              <div id="email_message" class="bg-info"></div>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" id="add_data" class="btn btn-success">Add</button>
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
                $('#email_message').html('<label class="text-danger">There is an id with this email</label>');
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


