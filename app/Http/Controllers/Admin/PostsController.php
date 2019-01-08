<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Department;
use App\Model\Admin\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends Controller
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
        if (Auth::user()->can('post_show')) 
        {
           //$posts = Post::orderBy('id','desc')->get();
            return view('admin.posts.list');
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
        if (Auth::user()->can('post_create')) 
        {
           $departments = Department::all();
           //$levelterm = LevelTerm::all();
           return view('admin.posts.add')->with('departments',$departments);
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
                'department_slug'=>'required',
                'level_term_slug'=>'required',
                // 'course_id'      =>'required',
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
                $NewFileToStore     = $request->department_slug.'_'.$request->level_term_slug.'_'.$request->course_id.'_'.time().'.'.$extension;
                //save new data
                $path               = $request->file('image')->storeAs('public/posts/',$NewFileToStore);
            }else{
                $NewFileToStore     = '';
            }

            $course_data = '';
            if($request->has('course_id')){
                $course_data .= $this->getCourseDetails($request->course_id);
                //dd($course_data);
            }

            $post = new Post;

            $post->name = $request->name;
            $post->author = $request->author;
            $post->department_slug = $request->department_slug;
            $post->level_term_slug = $request->level_term_slug;
            $post->course_id = $request->course_id;
            $post->link = $request->link;
            $post->status = $request->status;
            $post->user_id = $request->user_id;
            $post->user_type = $request->user_type;
            $post->post_type = $request->post_type;
            $post->image = $NewFileToStore;
            $post->custom_message = $request->custom_message;
            $post->description = $request->name.' '.$request->author.' '.$request->department_slug.' '.$request->level_term_slug.' '.$request->custom_message.' '.$course_data; 
            $post->save();
            //save activity
            $this->save('admin',Auth::user()->id,'added','Post',$post->id,$post->name);


            return redirect()->route('posts.index')->with('success','Post Added');
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
        if (Auth::user()->can('post_update')) 
        {
            $post = Post::find($id);
            $departments = Department::all();
            return view('admin.posts.edit')->with('post',$post)->with('departments',$departments);
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
            'department_slug'=>'required',
            'level_term_slug'=>'required',
            // 'course_id'      =>'required',
            'link'           =>'required',
            'status'         =>'required',
            'user_id'        =>'required',
            'user_type'      =>'required',
        ]);

        $course_data = '';
        if($request->has('course_id')){
            $course_data .= $this->getCourseDetails($request->course_id);
            //dd($course_data);
        }

        $post = Post::find($id);
        $old_image = $post->image;


        if ($request->hasFile('image')) {
            //delete old image
            if(!empty($post->image)){
                Storage::delete('public/posts/'.$old_image);
            }
            //retrive new file data
            $fileNameWithExt    =  $request->file('image')->getClientOriginalName();
            $fileNameWithoutExt = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension          = $request->file('image')->getClientOriginalExtension();
            $NewFileToStore     = $request->department_slug.'_'.$request->level_term_slug.'_'.$request->course_id.'_'.time().'.'.$extension;
            //save new data
            $path               = $request->file('image')->storeAs('public/posts/',$NewFileToStore);
        }else{
            $NewFileToStore     = $post->image;
        }

        $post->name = $request->name;
        $post->author = $request->author;
        $post->department_slug = $request->department_slug;
        $post->level_term_slug = $request->level_term_slug;
        $post->course_id = $request->course_id;
        $post->link = $request->link;
        $post->status = $request->status;
        $post->user_id = $request->user_id;
        $post->user_type = $request->user_type;
        $post->image = $NewFileToStore;
        $post->custom_message = $request->custom_message;
        $post->description = $request->name.' '.$request->author.' '.$request->department_slug.' '.$request->level_term_slug.' '.$request->custom_message.' '.$course_data; 
        $post->save();

        //save activity
        $this->save('admin',Auth::user()->id,'updated','Post',$post->id,$post->name);
        return redirect()->route('posts.index')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('post_delete')) 
        {
            $post = Post::find($id);
            if (!empty($post->image)) {
                Storage::delete('/posts/'.$post->image);
                $post->delete();
            }else{
                 $post->delete();
            }
            //dd($post->name);
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Post',$post->id,$post->name);
            return redirect()->route('posts.index')->with('success','Post Deleted');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    public static function status($code){
        switch ($code) {
            case 1:
                return '<span class="label label-success">Online</span>';
                break;
            case 2:
                return '<span class="label label-warning">Pending</span>';
                break;
            case 3:
                return '<span class="label label-danger">Drafted</span>';
                break;
            
            default:
                return '<span class="label label-info">Undefined</span>';
                break;
        }
    }

    public function getPostById(Request $request){
       //return $request->all(); exit;
        $result = Post::find($request->id);
        return $result;
    }

    public function getCourseDetails($course_id){
        $course_data = DB::table('courses')->where('id',$course_id)->first();
        return $course_data->description;
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
        $posts = Post::get(['posts.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        return DataTables::of($posts)
            ->addColumn('action', function ($post) {
                $col_to_show = '<a href="#" class="btn btn-primary" id="modal_switch" data-id='.$post->id.'><i class="fa fa-eye"></i></a>';
                if (Auth::user()->can('post_update')) 
                {
                    $col_to_show .= '  <a href="'.route('posts.edit',$post->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
                }  
                if (Auth::user()->can('post_delete'))
                { 
                $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$post->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-'.$post->id.'" action="'.route('posts.destroy',$post->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                      </form>';
                }
                return $col_to_show;
            })
            ->addColumn('courseData',function($post){
                return $post->courseData();
            })
            ->addColumn('status',function($post){
                return $post->status($post->id);
            })
            ->addColumn('uploader',function($post){
                return $post->uploader()->name;
            })
            ->rawColumns(['courseData','status','action'])
            ->make(true);
    }

}
