<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Department;
use App\Model\Admin\LevelTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Activity;

class LevelTermsController extends Controller
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
        if (Auth::user()->can('level_term_show')) {
            $level_terms = LevelTerm::orderBy('id','desc')->get();
            return view('admin.level_terms.list')->with('level_terms',$level_terms);
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
        if (Auth::user()->can('level_term_create')) {
            $departments = Department::all();
            return view('admin.level_terms.add')->with('departments',$departments);
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
        //return $request->all();
        $this->validate($request, [
            'name'=>'required',
            'slug'=>'required',
            'department_id'=>'required',
        ]);

        $level_term = new LevelTerm;

        $level_term->name           = $request->name;
        $level_term->slug           = $request->slug;
        $level_term->department_id  = $request->department_id;
        $level_term->custom_message = $request->custom_message;
        $level_term->description    = $request->name.' '.$request->slug;
        $level_term->save();

        //save activity
        $this->save('admin',Auth::user()->id,'added','LevelTerm',$level_term->id,$level_term->name);

        return redirect(route('levelterms.index'))->with('success','Level term added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('level_term_update')) {
            $departments = Department::all();
            $levelterm   = LevelTerm::find($id);

            return view('admin.level_terms.edit')->with('departments',$departments)->with('levelterm',$levelterm);
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
        $this->validate($request, [
        'name'=>'required',
        'slug'=>'required',
        'department_id'=>'required',
    ]);

    $level_term = LevelTerm::find($id);

    $level_term->name           = $request->name;
    $level_term->slug           = $request->slug;
    $level_term->department_id  = $request->department_id;
    $level_term->custom_message = $request->custom_message;
    $level_term->description    = $request->name.' '.$request->slug;
    $level_term->save();

    //save activity
    $this->save('admin',Auth::user()->id,'updated','LevelTerm',$level_term->id,$level_term->name);


    return redirect(route('levelterms.index'))->with('success','Level term Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('level_term_delete')) {
            $levelterm = LevelTerm::find($id);
            $levelterm->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','LevelTerm',$levelterm->id,$levelterm->name);
            return redirect(route('levelterms.index'))->with('success','Level term Deleted');
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
