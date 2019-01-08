<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Admin;
use App\Model\Admin\Book;
use App\Model\Admin\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BooksController extends Controller
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
        if (Auth::user()->can('book_show')) 
        {
            //$books = Book::orderBy('id','desc')->get();
            return view('admin.books.list');
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
        if (Auth::user()->can('book_create')) 
        {
            $departments = Department::all();
            //$levelterm = LevelTerm::all();
            return view('admin.books.add')->with('departments',$departments);
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
                $path               = $request->file('image')->storeAs('public/books/',$NewFileToStore);
            }else{
                $NewFileToStore     = '';
            }

            $book = new Book;

            $book->name = $request->name;
            $book->author = $request->author;
            $book->department_slug = $request->department_slug;
            $book->level_term_slug = $request->level_term_slug;
            $book->course_id = $request->course_id;
            $book->link = $request->link;
            $book->status = $request->status;
            $book->user_id = $request->user_id;
            $book->user_type = $request->user_type;
            $book->post_type = $request->post_type;
            $book->image = $NewFileToStore;
            $book->custom_message = $request->custom_message;
            $book->description = $request->name.' '.$request->author.' '.$request->department_slug.' '.$NewFileToStore.' '.$request->custom_message; 
            $book->save();

            //save activity
            $this->save('admin',Auth::user()->id,'added','Book',$book->id,$book->name);

            return redirect()->route('books.index')->with('success','Book Added');
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
        if (Auth::user()->can('book_update')) 
        {
            $book = Book::find($id);
            $departments = Department::all();
            return view('admin.books.edit')->with('book',$book)->with('departments',$departments);
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

        $book = Book::find($id);
        $old_image = $book->image;


        if ($request->hasFile('image')) {
            //delete old image
            if (!empty($book->image)) {
                Storage::delete('public/books/'.$old_image);
            }
            
            //retrive new file data
            $fileNameWithExt    =  $request->file('image')->getClientOriginalName();
            $fileNameWithoutExt = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension          = $request->file('image')->getClientOriginalExtension();
            $NewFileToStore     = $fileNameWithoutExt.'_'.$request->user_id.'_'.time().'.'.$extension;
            //save new data
            $path               = $request->file('image')->storeAs('public/books/',$NewFileToStore);
        }else{
            $NewFileToStore     = $book->image;
        }

        $book->name = $request->name;
        $book->author = $request->author;
        $book->department_slug = $request->department_slug;
        $book->level_term_slug = $request->level_term_slug;
        $book->course_id = $request->course_id;
        $book->link = $request->link;
        $book->status = $request->status;
        $book->user_id = $request->user_id;
        $book->user_type = $request->user_type;
        $book->image = $NewFileToStore;
        $book->custom_message = $request->custom_message;
        $book->description = $request->name.' '.$request->author.' '.$request->department_slug.' '.$request->level_term_slug.' '.$request->custom_message; 
        $book->save();
        //save activity
        $this->save('admin',Auth::user()->id,'updated','Book',$book->id,$book->name);
        return redirect()->route('books.index')->with('success','Book Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('book_delete')) 
        {
           $book = Book::find($id);
           //dd($book);
            if (!empty($book->image)) {
                Storage::delete('public/books/'.$book->image);
                $book->delete();
            }else{
                $book->delete();
            }
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Book',$book->id,$book->name);
            return redirect()->route('books.index')->with('success','Book Deleted');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
    }



    public function getBookById(Request $request){
       //return $request->all();
        $result = Book::find($request->id);
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
        $books = Book::get(['books.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        return DataTables::of($books)
            ->addColumn('action', function ($book) {
                $col_to_show = '<a href="#" class="btn btn-primary" id="modal_switch" data-id='.$book->id.'><i class="fa fa-eye"></i></a>';
                if (Auth::user()->can('book_update')) 
                {
                    $col_to_show .= '  <a href="'.route('books.edit',$book->id).'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>';
                }  
                if (Auth::user()->can('book_delete'))
                { 
                $col_to_show .= '  <a href="#" onclick="if(confirm(\'are you sure ?\')){ event.preventDefault();document.getElementById(\'delete-form-'.$book->id.'\').submit();}else{event.preventDefault();}" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                      <form id="delete-form-'.$book->id.'" action="'.route('books.destroy',$book->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                      </form>';
                }
                return $col_to_show;
            })
            ->addColumn('status', function ($book) {
                return $this->status($book->status);
            })
            ->addColumn('uploader',function($book){
                return $this->uploader($book->user_id);
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    public function status($status){
        //$book = Book::find($id);

        //$status = $book->status;

        switch ($status) {
            case 1:
                return '<span class="label label-success">Online</span>';
                break;
            case 2:
                return '<span class="label label-warning">Pending</span>';
                break;
            case 3:
                return '<span class="label label-primary">Drafted</span>';
                break;
            case 4:
                return '<span class="label label-info">Private</span>';
                break;
            case 5:
                return '<span class="label label-danger">Rejected</span>';
                break;
            
            default:
                return '<span class="label label-info">Undefined</span>';
                break;
        }
    }
    
    public function uploader($user_id){
        $uploader =  Admin::find($user_id);
        return $uploader->name;
    }


}
