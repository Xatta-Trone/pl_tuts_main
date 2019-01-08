<?php

namespace App\Http\Controllers;

use App\Model\Admin\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::where([['causer','=','user'],['causer_id','=',Auth::user()->id]])->orderBy('id','desc')->limit(15)->get();
        //dd($activities);
        return view('user.profile',compact('activities'));
    }
}
