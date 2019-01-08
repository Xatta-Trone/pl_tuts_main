@extends('admin.app')

@section('page_title','Admins')

@section('extra_css')
  <link rel="stylesheet" href="{{ asset('admin_res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
@endsection
@php
  use App\Http\Controllers\Admin\PostsController;
@endphp
@section('main_content')  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display: inline-block;">
        Admin List
      </h1>
      @can('admin_create')
        <a href="{{ route('admins.create') }}" class="btn btn-success pull-right ">Add New</a>
      @endcan
    </section>

    <!-- Main content -->
    <section class="content">
      @include('includes.messages')


       <div class="box">
         <div class="box-header">
           
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <table id="example1" class="table table-bordered table-striped table-responsive">
             <thead>
             <tr>
                <th>#</th>
                <th>Name</th>
                <th>Student Id</th>
                <th>Email</th>
                <th>Roles</th>
                <th>User Letter</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </thead>
             <tbody>
             @foreach($admins as $admin)
                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->student_id }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>
                    @foreach ($admin->roles as $role)
                      {{ $role->name }} |
                    @endforeach
                  </td>
                  <td>{{ $admin->user_letter }}</td>
                  <td>{!! ($admin->status == 1) ? '<span class="label label-success">Active</span>':'<span class="label label-danger">Inactive</span>' !!}</td>
                  <td>
                    @can('admin_update')
                      <a href="{{ route('admins.edit',$admin->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can('admin_delete')
                      <a href="#" onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$admin->id}}').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-{{$admin->id}}" action="{{ route('admins.destroy',$admin->id) }}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                      </form>
                    @endcan

                  </td>
                </tr>
             @endforeach
             </tbody>
             <tfoot>
             <tr>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Student Id</th>
                <th>Email</th>
                <th>Roles</th>
                <th>User Letter</th>
                <th>Status</th>
                <th>action</th>
              </tr>
             </tr>
             </tfoot>
           </table>
         </div>
         <!-- /.box-body -->
       </div>
       <!-- /.box -->
    </section>
    <!-- /.content -->

   
@endsection
