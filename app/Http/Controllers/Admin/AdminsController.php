<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminLoginDetails;
use App\Model\Admin\Admin;
use App\Model\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('admin_show')) 
        {
            $admins = Admin::where('id','<>','1')->orderBy('id','desc')->get();
            return view('admin.admins.list')->with('admins',$admins);
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('admin_create')) 
        {
            $roles = Role::all();
            return view('admin.admins.add')->with('roles',$roles);
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();

        $this->validate($request, [
            'name'      =>'required',
            'student_id'=>'required',
            'email'     =>'required',
        ]);
        $password = Str::random(8);

        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->student_id = $request->student_id;
        $admin->status = $request->status ? : 0;
        $admin->user_letter = substr($request->name,0,1);
        $admin->password = bcrypt($password);

        $admin->save();
        $admin->roles()->sync($request->role);
        $adminData = $request->all();
        $adminData['password'] = $password;
        $adminData = (object) $adminData;
        $this->sendEmail($adminData);
        //dd($adminData);
        //save activity
        $this->save('admin',Auth::user()->id,'added','Admin',$admin->id,$admin->name);
        return redirect()->route('admins.index')->with('success','Admin added successfully');
    }

    public function sendEmail($adminData){
        Mail::to($adminData->email)->send(new AdminLoginDetails($adminData));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('admin_update')) 
        {
            $admin = Admin::find($id);
            $roles = Role::all();
            return view('admin.admins.edit')->with('roles',$roles)->with('admin',$admin);
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //return $request->all();
         $this->validate($request, [
            'name'      =>'required',
            'student_id'=>'required',
            'email'     =>'required',
        ]);

         $admin = Admin::find($id);
         $admin->name = $request->name;
         $admin->email = $request->email;
         $admin->student_id = $request->student_id;
         $admin->user_letter = $request->user_letter;
         $admin->status = $request->status ? : 0;

         $admin->save();
         //return $request->role;
         Admin::find($id)->roles()->sync($request->role);
         //save activity
         $this->save('admin',Auth::user()->id,'updated','Admin',$admin->id,$admin->name);
         return redirect()->route('admins.index')->with('success','Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('admin_delete')) 
        {
            $admin = Admin::find($id);
            $admin->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Admin',$admin->id,$admin->name);
            return redirect()->route('admins.index')->with('success','Admin Deleted successfully');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    /*
        @params $causer    = admin/user
        @params $causer_id = admin_id/user_id
        @params $activity  = added/deleted/updated/searched/downloaded
        @params $model     = model name
        @params $model_id  = the id which is affected
        @params $label     = string | when there is no id to strore
    */
    public function save($causer = null,$causer_id = null,$activity = null,$model = null,$model_id = null,$label = null){
        //label is for searching
        $activity_to_log = new Activity;

        $activity_to_log->causer = $causer;
        $activity_to_log->causer_id = $causer_id;
        $activity_to_log->activity = $activity;
        $activity_to_log->model = $model;
        $activity_to_log->model_id = $model_id;
        $activity_to_log->label = $label;
        $activity_to_log->save();
        //return ;
    }

    public function profile(){
        $admin = Auth::user();
        //dd(Auth::user());

        return view('admin.admins.profile')->with('admin',$admin);
    }

    public function profileUpdate(Request $request){
        //return $request->all();
        //  $this->validate($request, [
        //     'name'      =>'required',
        //     'student_id'=>'required',
        //     'email'     =>'required',
        // ]);

         $admin = Admin::where('id',$request->id)->first();
         //return $admin;
         $admin->name = $request->name;
         $admin->email = $request->email;
         $admin->user_letter = $request->user_letter;

         $admin->save();
         $message['message'] = 'Profile Updated successfully.';
         $message['success'] = 'true';

         return $message;
    }

    public function customPasswordChange(Request $request){
        //return $request->all();
        $message = [];
        $old_password = $request->old_password;


        if (!(Hash::check($old_password, Auth::user()->password))) {
            $message['message'] = 'old password do not match';
            $message['success'] = 'false';
            return $message;

        }

        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            $message['message'] = 'new password can not be same as old password';
            $message['success'] = 'false';
            return $message;
        }

        $user = Auth::user();
        //return $user;
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        $message['message'] = 'password changed successfully.';
        $message['success'] = 'true';

        return $message;

    }
}
