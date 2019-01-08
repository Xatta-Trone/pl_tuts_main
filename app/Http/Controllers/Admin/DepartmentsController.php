<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Activity;

class DepartmentsController extends Controller
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
        if (Auth::user()->can('department_show')) {
            $departments = Department::all();
            return view('admin.departments.list')->with('departments',$departments);
        }else{
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
        if (Auth::user()->can('department_create')) {
            return view('admin.departments.add');
        }else{
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
       // return $request->all();

        $this->validate($request, [
                'dept_name'=>'required',
                'slug'=>'required',
                'dept_code'=>'required',
                'image'=>'image|max:2000',
            ]);

        $description        = $request->dept_name.' '.$request->dept_code.' '.$request->slug;
        $fileNameWithExt    =  $request->file('image')->getClientOriginalName();
        $fileNameWithoutExt = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        $extension          = $request->file('image')->getClientOriginalExtension();
        $NewFileToStore     = $request->slug.'_'.$request->dept_code.'.'.$extension;
        //return $NewFileToStore;
        $path               = $request->file('image')->storeAs('public/departments/',$NewFileToStore);

        $department = new Department;

        $department->dept_name      = $request->dept_name;
        $department->dept_code      = $request->dept_code;
        $department->slug           = $request->slug;
        $department->custom_message = $request->custom_message;
        $department->image          = $NewFileToStore;
        $department->description    = $description;

        $department->save(); 
        //save activity
        $this->save('admin',Auth::user()->id,'added','Department',$department->id,$department->dept_name);

        return redirect()->route('departments.index')->with('success','Department Added');

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
        //return $id;
        if (Auth::user()->can('department_update')) {
            $department = Department::find($id);
            return view('admin.departments.edit')->with('department',$department);
        }else{
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
        //return $request->all(); exit;
        $this->validate($request, [
                'dept_name'=>'required',
                'slug'=>'required',
                'dept_code'=>'required',
                
            ]);
        $department = Department::find($id);
        $old_image  = $department->image;

       //dd ( $request->hasFile('image'));

        if ($request->hasFile('image')) {
            //delete old image
            Storage::delete('public/departments/'.$old_image);
            //retrive new file data
            $fileNameWithExt    =  $request->file('image')->getClientOriginalName();
            $fileNameWithoutExt = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension          = $request->file('image')->getClientOriginalExtension();
            $NewFileToStore     = $request->slug.'_'.$request->dept_code.'.'.$extension;
            //save new data
            $path               = $request->file('image')->storeAs('public/departments/',$NewFileToStore);
        }else{
            $NewFileToStore     = $department->image;
        }

        $description                = $request->dept_name.' '.$request->dept_code.' '.$request->slug;

        $department->dept_name      = $request->dept_name;
        $department->dept_code      = $request->dept_code;
        $department->slug           = $request->slug;
        $department->custom_message = $request->custom_message;
        $department->image          = $NewFileToStore;
        $department->description    = $description;

        $department->save();
        //save activity
        $this->save('admin',Auth::user()->id,'updated','Department',$department->id,$department->dept_name);


        return redirect()->route('departments.index')->with('success','Department Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('department_delete')) {
            $department = Department::find($id);
            $image      = $department->image;
            Storage::delete('public/departments/'.$image);
            $department->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Department',$department->id,$department->dept_name);

            return redirect()->route('departments.index')->with('success','Department Deleted');
        }else{
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
}
