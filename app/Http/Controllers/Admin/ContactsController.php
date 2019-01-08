<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Activity;

class ContactsController extends Controller
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
        if (Auth::user()->can('contact_view')) 
        {
            $contacts = Contact::orderBy('id','desc')->get();
            return view('admin.contacts.list')->with('contacts',$contacts);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        if (Auth::user()->can('contact_reply')) 
        {
            $contact = Contact::find($id);
            return view('admin.contacts.edit')->with('contact',$contact);
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
        $mail = Contact::find($id);
        $mail->replied = 1;
        $mail->replied_by = Auth::user()->id;
        $mail->save();

        $data = [
            'from'=>$request->from,
            'to'=>$request->to,
            'subject'=>$request->subject,
            'body'=>$request->body,
        ];

        Mail::send('email.contact',$data,function($message) use ($data){
            $message->to($data['to']);
            $message->replyTo('pltutorialsbuet@gmail.com');
            $message->subject($data['subject']);
        });
        //save activity
        $this->save('admin',Auth::user()->id,'replied','Contact',$mail->id,$mail->email);
        Session::flash('success', 'Your email was sent.');

        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('contact_delete')) 
        {
            $mail = Contact::find($id);
            $mail->delete();
            //save activity
            $this->save('admin',Auth::user()->id,'deleted','Contact',$mail->id,$mail->email);
            Session::flash('success', 'Mail deleted');

            return redirect()->route('contacts.index');
        }
        else
        {
            return redirect()->route('admin.home')->with('warning','You are not authorized to access that page');
        }
        
    }

    public function getContactDataById(Request $request){
       //return $request->all();
        $result = Contact::find($request->id);
        $result->status = 1;
        $result->save();
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
