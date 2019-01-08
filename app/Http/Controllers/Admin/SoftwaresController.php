<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Department;
use App\Model\Admin\Software;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SoftwaresController extends Controller
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
        if (Auth::user()->can('software_show')) 
        {
            //$softwares = Software::orderBy('id','desc')->get();
            return view('admin.softwares.list');
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
        if (Auth::user()->can('software_create')) 
        {
            $departments = Department::all();
            //$levelterm = LevelTerm::all();
            return view('admin.softwares.add')->with('departments',$departments);
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
                'name'           =>'required',
                'link'           =>'required',
                'status'         =>'required',
                'user_id'        =>'required',
                'user_type'      =>'required',
            ]);

        if ($request->hasFile('image')) {
                //retrive new file data
                $fileNameWithExt    =  $request->file('image')->getClientOriginalName();
                $fileNameWithoutExt = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                $extension          = $request->file('image')->getClientOriginalExtension();
                $NewFileToStore     = $fileNameWithoutExt.'_'.$request->user_id.'_'.time().'.'.$extension;
                //save new data
                $path               = $request->file('image')->storeAs('public/softwares/',$NewFileToStore);
            }else{
                $NewFileToStore     = '';
            }

            $software = new Software;

            $software->name = $request->name;
            $software->author = $request->author;
            $software->department_slug = $request->department_slug;
            $software->level_term_slug = $request->level_term_slug;
            $software->course_id = $request->course_id;
            $software->link = $request->link;
            $software->status = $request->status;
            $software->user_id = $request->user_id;
            $software->user_type = $request->user_type;
            $software->post_type = $request->post_type;
            $software->image = $NewFileToStore;
            $software->custom_message = $request->custom_message;
            $software->description = $request->name.' '.$request->author.' '.$request->department_slug.' '.$NewFileToStore.' '.$request->custom_message; 
            $software->save(); 
            //save activity
            $this->save('admin',Auth::user()->id,'added','Software',$software->id,$software->name);
  
            return redirect()->route('softwares.index')->with('success','Software Added');
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
        if (Auth::user()->can('software_update')) 
        {
            $software = Software::find($id);
            $departments = Department::all();
            return view('admin.softwares.edit')->with('software',$software)->with('departments',$departments);
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
            'name'           =>'required',
            'link'           =>'required',
            'status'         =>'required',
            'user_id'        =>'required',
            'user_type'      =>'required',
        ]);

        $software = Software::find($id);
        $old_image = $software->image;


        if ($request->hasFile('image')) {
            //delete old image
            if(!empty($software->image)){
                Storage::delete('public/softwares/'.$old_image);
            }
            //retrive new file data
            $fileNameWithExt    =  $request->file('image')->getClientOriginalName();
            $fileNameWithoutExt = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension          = $request->file('image')->getClientOriginalExtension();
            $NewFileToStore     = $fileNameWithoutExt.'_'.$request->user_id.'_'.time().'.'.$extension;
            //save new data
            $path               = $request->file('image')->storeAs('public/softwares/',$NewFileToStore);
        }else{
            $NewFileToStore     = $software->image;
        }

        $software->name = $request->name;
        $software->author = $request->author;
        $software->department_slug = $request->department_slug;
        $software->level_term_slug = $request->level_term_slug;
        $software->course_id = $request->course_id;
        $software->link = $request->link;
        $software->status = $request->status;
        $software->user_id = $request->user_id;
        $software->user_type = $request->user_type;
        $software->image = $NewFileToStore;
        $software->custom_message = $request->custom_message;
        $software->description = $request->name.' '.$request->author.' '.$request->department_slug.' '.$request->level_term_slug.' '.$request->custom_message; 
        $software->save();
        //save activity
        $this->save('admin',Auth::user()->id,'updated','Software',$software->id,$software->name);
        
        return redirect()->route('softwares.index')->with('success','Software Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('software_delete')) 
        {
            //dd(public_path());
            $software = Software::find($id);
            if (!empty($software->image)) {
                Storage::delete('/softwares/'.$software->image);
                $software->delete();
            }else{
                $software->delete();
            }
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Software',$software->id,$software->name);
            
            return redirect()->route('softwares.index')->with('success','Software Deleted');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }
    public function getSoftwareById(Request $request){
       //return $request->all();
        $result = Software::find($request->id);
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

    public function listdata(){

        DB::statement(DB::raw('set @rownum=0'));
        $softwares = Software::get(['softwares.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        return DataTables::of($softwares)
            ->addColumn('action', function ($software) {
                $col_to_show = '<a href="#" class="btn btn-primary" id="modal_switch" data-id='.$software->id.'><i class="fa fa-eye"></i></a>';
                if (Auth::user()->can('software_update')) 
                {
                    $col_to_show .= '  <a href="'.route('softwares.edit',$software->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
                }  
                if (Auth::user()->can('software_delete'))
                { 
                $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$software->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-'.$software->id.'" action="'.route('softwares.destroy',$software->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                      </form>';
                }
                return $col_to_show;
            })
            ->addColumn('status',function($software){
                return $software->status($software->id);
            })
            ->addColumn('uploader',function($software){
                return $software->uploader()->name;
            })
            ->rawColumns(['courseData','status','action'])
            ->make(true);
    }
}
