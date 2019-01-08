<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Course;
use App\Model\Admin\Department;
use App\Model\Admin\LevelTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
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
        if (Auth::user()->can('course_show')) 
        {
            //$courses     = Course::orderBy('id','desc')->get();
            //$departments = Department::all();
            return view('admin.courses.list');
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
        if (Auth::user()->can('course_create')) 
        {
            $departments = Department::all();
            //$levelterm = LevelTerm::all();
            return view('admin.courses.add')->with('departments',$departments);
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
        $this->validate($request, [
            'course_name'=>'required',
            'slug'=>'required',
            'department_id'=>'required',
            'level_term_id'=>'required',
        ]);

        $course = new Course;

        $course->course_name    = $request->course_name;
        $course->slug           = $request->slug;
        $course->department_id  = $request->department_id;
        $course->level_term_id  = $request->level_term_id;
        $course->custom_message = $request->custom_message;
        $course->description    = $request->course_name.' '.$request->slug.' '.$request->custom_message;

        $course->save();
        //save activity
        $this->save('admin',Auth::user()->id,'added','Course',$course->id,$course->course_name);
        return redirect()->route('courses.index')->with('success','Course Added');
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
        if (Auth::user()->can('course_update')) 
        {
            $course      = Course::find($id);
           $departments = Department::all();
           $levelterms  = DB::table('level_terms')->where('department_id',$course->department_id)->orderBy('name','asc')->get();

           return view('admin.courses.edit')->with('departments',$departments)->with('levelterms',$levelterms)->with('course',$course);
                
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
        $this->validate($request, [
            'course_name'=>'required',
            'slug'=>'required',
            'department_id'=>'required',
            'level_term_id'=>'required',
        ]);

        $course =  Course::find($id);

        $course->course_name    = $request->course_name;
        $course->slug           = $request->slug;
        $course->department_id  = $request->department_id;
        $course->level_term_id  = $request->level_term_id;
        $course->custom_message = $request->custom_message;
        $course->description    = $request->course_name.' '.$request->slug.' '.$request->custom_message;

        $course->save();
        //save activity
        $this->save('admin',Auth::user()->id,'updated','Course',$course->id,$course->course_name);
        return redirect()->route('courses.index')->with('success','Course Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('course_delete')) 
        {        
            $course = Course::find($id);
            $course->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Course',$course->id,$course->course_name);
            return redirect()->route('courses.index')->with('success','Course Deleted');    
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    public function getLevelTerm(Request $request){
        $result = DB::table('level_terms')->where('department_id',$request->department_id)->orderBy('name','asc')->get();
        //return $result;
        $output = '<option value="">Select Level Term</option>';
        foreach ($result as $levelterm) {
           $output .= '<option value='.$levelterm->id.' data-levelterm='.$levelterm->id.'>'. $levelterm->name.'</option>';
        }
        return $output;
    }
    public function getLevelTermBySlug(Request $request){
        $result = DB::table('level_terms')->where('department_id',$request->department_id)->orderBy('name','asc')->get();
        //return $result;
        $output = '<option value="">Select Level Term</option>';
        foreach ($result as $levelterm) {
           $output .= '<option value='.$levelterm->slug.' data-levelterm='.$levelterm->id.'>'. $levelterm->name.'</option>';
        }
        return $output;
    }
    public function getLevelTermDataOnly(Request $request){
        $result = DB::table('level_terms')->where('department_id',$request->department_id)->orderBy('name','asc')->get();
        return $result;
        //return $output;
    }

    public function getCourses(Request $request){
        //return $request->all(); exit;
        $courses = DB::table('courses')
                    ->where([
                        ['department_id','=', $request->department_id],
                        ['level_term_id','=', $request->level_term_id]
                    ])->get();
        return $courses;
        
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
        $courses = Course::get(['courses.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        return DataTables::of($courses)
            ->addColumn('action', function ($course) {
                $col_to_show = '';
                if (Auth::user()->can('course_update')) 
                {
                    $col_to_show .= '  <a href="'.route('courses.edit',$course->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
                }  
                if (Auth::user()->can('course_delete'))
                { 
                $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$course->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-'.$course->id.'" action="'.route('courses.destroy',$course->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                      </form>';
                }
                return $col_to_show;
            })
            ->addColumn('department',function($course){
                return $course->department->dept_name;
            })

            ->addColumn('levelterm',function($course){
                return $course->levelterm->slug;
            })
            //->orderColumn('id', 'id $1')
            ->make(true);
    }


}
