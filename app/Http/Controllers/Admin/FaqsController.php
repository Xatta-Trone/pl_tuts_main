<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Activity;

class FaqsController extends Controller
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
        if (Auth::user()->can('faq_show')) 
        {
            $faqs = Faq::orderBy('id','desc')->get();
            return view('admin.faqs.list')->with('faqs',$faqs);
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
        if (Auth::user()->can('faq_create')) 
        {
            return view('admin.faqs.add');
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
                'title'           =>'required',
                'body'           =>'required',
                'status'         =>'required',
            ]);

            $faq = new Faq;

            $faq->title = $request->title;
            $faq->body = $request->body;
            $faq->status = $request->status;
            $faq->save();  

            //save activity
            $this->save('admin',Auth::user()->id,'added','Faq',$faq->id,$faq->title); 

            return redirect()->route('faqs.index')->with('success','FAQ Added');
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
        if (Auth::user()->can('faq_update')) 
        {
            $faq = Faq::find($id);
            return view('admin.faqs.edit')->with('faq',$faq);
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
            'title'           =>'required',
            'body'           =>'required',
            'status'         =>'required',
        ]);

        $faq = Faq::find($id);

        $faq->title = $request->title;
        $faq->body = $request->body;
        $faq->status = $request->status;
        $faq->save();  
        //save activity
        $this->save('admin',Auth::user()->id,'updated','Faq',$faq->id,$faq->title); 

        return redirect()->route('faqs.index')->with('success','FAQ Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('faq_delete')) 
        {
            $faq = Faq::find($id);
            $faq->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Faq',$faq->id,$faq->title); 
            return redirect()->route('faqs.index')->with('success','Faq Deleted');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }
    

    public function getFaqById(Request $request){
       //return $request->all();
        $result = Faq::find($request->id);
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
