<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\loginDetails;
use App\Model\Admin\Activity;
use App\Model\Admin\Userdata;
use App\Model\User\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserDataController extends Controller
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
        if (Auth::user()->can('userdata_show')) 
        {
            //$user_datas = Userdata::all();
            return view('admin.userdata.list');
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
        if (Auth::user()->can('userdata_import')) 
        {
            return view('admin.userdata.add');
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
        $this->validate($request, array(
            'file'      => 'required'
        ));
        
        $file = Input::file('file');
        $fileName = $file->getClientOriginalName();
        //return $fileName;
        $file->move('files',$fileName);

        $results = Excel::load('files/'.$fileName,function($reader){
            $reader->all();
        })->get();
        $this->insertData($results);
        //save activity
        $this->save('admin',Auth::user()->id,'added','Userdata','',$fileName);

        $user_datas = Userdata::all();
        return view('admin.userdata.list')->with('success','User Data inserted')->with('user_datas',$user_datas);
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
        if (Auth::user()->can('user_create')) 
        {
            $user = Userdata::find($id);
        return view('admin.userdata.edit')->with('user',$user);
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
        $user = Userdata::find($id);
        $user['email'] = $request->email;
        $user['password'] = Str::random(8);
        $user = (object) $user;
        //dd($user);
        $this->createNewAccount($user);

        $userdata = Userdata::find($user->id);
        //dd($userdata);
        $userdata->status = 1;
        $userdata->save();

        Session::flash('success','New user added');
        return redirect(route('userdata.index'));
    }

    public function studentIdWithoutPrefix($student_id){
        return (substr($student_id,0,1) == 's') ? substr($student_id,3) : $student_id;
    }

    public function createNewAccount($data){
        $student_id = strtolower($data->student_id);
        //dd($data);
        $user = new User;
        $user->name = $data->student_name;
        $user->student_id = $this->studentIdWithoutPrefix($student_id);
        $user->email = $data->email;
        $user->password = bcrypt($data->password);
        $user->user_letter = substr($this->userLetter($data->student_name),0,1);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertData($results){
        $results->each(function($sheet){
            $row = json_decode($sheet,true);
            if ($row['merit'] != null || !empty($row['merit'])) {
                $merit = $row['merit'];
                                    
                $student_id = $row['student_id'];

                $student_name = $row['name_english'];
                //$student_name = str_replace(".","",$student_name);

                $hall_name = $row['hall_name'];

                try{
                    //$data = [ 'merit'=> $merit,'student_id'=> $student_id,'student_name'=> $student_name,'hall_name'=> $hall_name,'status'=>'0'];
                    //dd($data);

                   //DB::table('exell_tests')->insert($data);
                    $Excel = new Userdata;
                    $Excel->merit = $merit;
                    $Excel->student_id = $student_id;
                    $Excel->student_name = $student_name;
                    $Excel->hall_name = $hall_name;
                    $Excel->status = 0;
                    $Excel->save();
                 }
                catch (QueryException $e) {
                       if ($this->isDuplicateEntryException($e)) {
                        echo "Data Not inserted because duplicate student id found";
                        
                       }

                       throw $e;

                }
               
            }
         });
    }

    private function isDuplicateEntryException(QueryException $e){

        $sqlState = $e->errorInfo[0];
        $errorCode  = $e->errorInfo[1];
        if ($sqlState === "23000" && $errorCode === 1062) {

        return true;
    }

        return false;
    }

    public function truncate(){
        Userdata::query()->truncate();
        return view('admin.userdata.list')->with('success','All User Data Deleted');
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
        $userdatas = DB::table('userdatas');
        return DataTables::of($userdatas)
            ->addColumn('status', function ($userdata) {
                return ($userdata->status == 1) ? '<span class="label label-success">Registered</span>':'<span class="label label-danger">Not Registered</span>';
            })
            ->addColumn('action', function ($userdata) {
                if (Auth::user()->can('user_create'))
                {
                    return ($userdata->status == 0) ? '<a href="'.route('userdata.edit',$userdata->id).'" class="btn btn-primary"><i class="fa fa-user-plus"></i></a>': '';
                }
            })
            ->rawColumns(['status','action'])
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
