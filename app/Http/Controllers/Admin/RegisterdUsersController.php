<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\loginDetails;
use App\Model\Admin\Activity;
use App\Model\Admin\Userdata;
use App\Model\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RegisterdUsersController extends Controller
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
        if (Auth::user()->can('user_show')) 
        {
            $users = User::orderBy('id','desc')->get();
            return view('admin.users.list')->with('users',$users);
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
        if (Auth::user()->can('user_create')) 
        {
            return view('admin.users.add');
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
        $student_id = strtolower($request->student_id);
        $student_id_without_prefix = $request->student_id = $this->studentIdWithoutPrefix($student_id); 
        //return $student_id_without_prefix;
        //return $request->all();

        //check for exitsing data
        $user = DB::table('userdatas')
            ->select('*')
            ->where('student_id', 'like', '%'.$student_id_without_prefix.'%')
            ->first();
        //$user = (array) $user;

        //dd($user);
        if ($user != null) {
            //$user = (array) $user;
            //dd($user);
            $registerd_user = DB::table('users')
                ->select('*')
                ->where('student_id', '=', $student_id_without_prefix)
                ->orWhere('email', '=', $request->email)
                ->get()->count();
            //dd($registerd_user);
            if ($registerd_user > 0) {
                Session::flash('danger','There is an id with these credentials');
                return view('admin.users.add');
            }else{
                $user->email = $request->email;
                $user->student_id = $student_id_without_prefix;
                $user->password = Str::random(8);
                //dd($user);
                $this->createNewAccount($user);
                //update userdata table
                $userdata = Userdata::find($user->id);
                //dd($userdata);
                $userdata->status = 1;
                $userdata->save();
                //dd($userdata);

                Session::flash('success','New user added');
                return redirect(route('users.index'));
            }
        }else{
            $user = (object) $request->all();
            //dd($user);
            $user->password = Str::random(8);
            //dd($user);
            $this->createNewAccount($user);

            Session::flash('success','New user added');
            return redirect(route('users.index'));
        }

    }

    public function studentIdWithoutPrefix($student_id){
        $student_id = strtolower($student_id);
        return (substr($student_id,0,1) == 's') ? substr($student_id,3) : $student_id;
    }
    public function createNewAccount($data){
        $user = new User;
        $user->name = $data->student_name;
        $user->student_id = $this->studentIdWithoutPrefix($data->student_id);
        //dd($user->student_id);
        $user->email = $data->email;
        $user->password = bcrypt($data->password);
        $user->user_letter = substr($this->userLetter($data->student_name),0,1); //substr($this->userLetter($data['student_name']),0,1),
        $user->save();
        //$data = (array) $data;
        //dd($data);
        $new_user = User::findOrFail($user->id);
        $new_user->password = $data->password;
        //dd($new_user);
        $this->sendEmail($new_user);

        //save activity
        $this->save('admin',Auth::user()->id,'added','User',$user->id,$user->name);
    }
    public function sendEmail($user){
        //dd($user);
        Mail::to($user['email'])->send(new loginDetails($user));
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
        if (Auth::user()->can('user_update')) 
        {
            $user = User::find($id);
            return view('admin.users.edit')->with('user',$user);
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

        $user = User::find($id);

        $user->name = $request->name;
        $user->student_id = $request->student_id;
        $user->email = $request->email;
        $user->user_letter = $request->user_letter;
        $user->status = $request->status;

        $user->save();

        //save activity
        $this->save('admin',Auth::user()->id,'updated','User',$user->id,$user->name);
        return redirect()->route('users.index')->with('success','user updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('user_delete')) 
        {
            //find user in databse 
            $user = User::find($id);
            //check for userdatas table

            $userdatas = Userdata::where('student_id','like',"%".$user->student_id."%")->first();
            //dd($userdatas);
            if (!is_null($userdatas)) {
                $userdatas->status = 0;
                $userdatas->save();
            }
            //dd($userdatas);
            $user->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','User',$user->id,$user->name);
            return redirect()->route('users.index')->with('success','user deleted');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }

        
    }

    public function checkExistingUser(Request $request){
        //return $request->all();
        $student_id = strtolower($request->student_id);
        $student_id_without_prefix =  (substr($student_id,0,1) == 's') ? substr($student_id,3) : $student_id;
        //return $student_id_without_prefix;
        $message = [];
        $user = DB::table('userdatas')
            ->select('*')
            ->where('student_id', 'like', '%'.$student_id_without_prefix.'%')
            ->get()->count();

        if ($user > 0) {
            $message['exists'] = 'This id matches in our user database';
        }else{
            $message['exists'] = 'This id do not matches in our user database';
        }

        $registerd_user = DB::table('users')
            ->select('*')
            ->where('student_id', '=',$student_id_without_prefix)
            ->get()->count();
        //dd($registerd_user);
        //return $registerd_user;
        if ($registerd_user > 0) {
            $message['registerd'] = 'This id matches in our registerd user database';
            $message['status'] = 1;
        }else{
            $message['registerd'] = 'This id is available for registering';
            $message['status'] = 0;
        }

        return $message;
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


    public function listdata(){

        DB::statement(DB::raw('set @rownum=0'));
        $users = User::get(['users.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                $col_to_show = '';
                $col_to_show = '<a href="#" class="btn btn-primary" id="userLocationModalSwitch" data-id='.$user->id.'><i class="fa fa-eye"></i></a>';
                if (Auth::user()->can('user_update')) 
                {
                    $col_to_show .= '  <a href="'.route('users.edit',$user->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
                }  
                if (Auth::user()->can('user_delete'))
                { 
                $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$user->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-'.$user->id.'" action="'.route('users.destroy',$user->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                      </form>';
                }
                return $col_to_show;
            })
            ->addColumn('status',function($user){
                return ($user->status == 1) ? '<span class="label label-success">Active</span>':'<span class="label label-danger">Not Active</span>';
            })
            ->addColumn('join_date',function($user){
                return Carbon::parse($user->created_at)->toFormattedDateString();
            })
            ->rawColumns(['status','action','join_date'])
            ->make(true);
        }




    public function userLetter($name = ''){
        $array = explode(" ",$name);
        if(count($array) == 1){
            return $array[0];
        }elseif($array[0] != 'Md' && $array[0] != 'Md.' && $array[0] != 'Mohammad'){
            return $array[0];
        }
        else{
            return $array[1];
        }
    }

}
