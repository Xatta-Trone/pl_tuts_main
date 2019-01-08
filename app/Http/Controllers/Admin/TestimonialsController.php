<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Activity;

class TestimonialsController extends Controller
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
        if (Auth::user()->can('testimonial_show')) 
        {
            $tests = Testimonial::orderBy('id','desc')->get();
            ///dd($tests);
            return view('admin.testimonials.list')->with('tests',$tests);
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
        if (Auth::user()->can('testimonial_create')) 
        {
            return view('admin.testimonials.add');
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
            'name'           =>'required',
            'user_letter'    =>'required',
            'dept_batch'    =>'required',
            'message'    =>'required',
            'status'         =>'required',
        ]);

        $testimonial = new Testimonial;

        $testimonial->name = $request->name;
        $testimonial->user_letter = $request->user_letter;
        $testimonial->dept_batch = $request->dept_batch;
        $testimonial->message = $request->message;
        $testimonial->status = $request->status;
        $testimonial->save();
        //save activity
        $this->save('admin',Auth::user()->id,'added','Testimonial',$testimonial->id,$testimonial->name);


        return redirect()->route('testimonials.index')->with('success','Tesimonial Added');
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
        if (Auth::user()->can('testimonial_update')) 
        {
            $testimonial = Testimonial::find($id);
            return view('admin.testimonials.edit')->with('testimonial',$testimonial);
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
            'name'           =>'required',
            'user_letter'    =>'required',
            'dept_batch'    =>'required',
            'message'    =>'required',
            'status'         =>'required',
        ]);

        $testimonial = Testimonial::find($id);

        $testimonial->name = $request->name;
        $testimonial->user_letter = $request->user_letter;
        $testimonial->dept_batch = $request->dept_batch;
        $testimonial->message = $request->message;
        $testimonial->status = $request->status;
        $testimonial->save();
        //save activity
        $this->save('admin',Auth::user()->id,'updated','Testimonial',$testimonial->id,$testimonial->name);


        return redirect()->route('testimonials.index')->with('success','Tesimonial Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('testimonial_delete')) 
        {
            $testimonial = Testimonial::find($id);
            $testimonial->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Testimonial',$testimonial->id,$testimonial->name);

            return redirect()->route('testimonials.index')->with('success','Testimonial Deleted');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    public function getTestimonialById(Request $request){
       //return $request->all();
        $result = Testimonial::find($request->id);
        return $result;
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
