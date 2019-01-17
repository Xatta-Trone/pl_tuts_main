<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\UserTrace;
use Browser;
use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Yajra\DataTables\Facades\DataTables;

class UserTracesController extends Controller
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


    public function saveUserLocationInfo(){

    	$ip_address = \Request::ip();
    	// $ip_address = '208.80.152.201';
    	$browser_info = Browser::detect();

    	$client = new GuzzleHttp\Client();
    	$res = $client->get("http://ip-api.com/json/".$ip_address);

    	$location_info =  json_decode($res->getBody()); 

    	if($res->getStatusCode() == 200 && $location_info->status === 'success'){


    	//dd($location_info);

	    	$user_trace                = new UserTrace();
	    	$user_trace->user_id       = Auth::user()->id;
	    	$user_trace->user_ip       = $ip_address;
	    	$user_trace->location_info =$res->getBody(); 
	    	$user_trace->browser_info  = $browser_info;

	    	$user_trace->save();

	    	//return 'ok';
    	}


    }


    public function show()
    {
    	$data = DB::table('user_traces')->first();

    	$new_data = json_decode($data->browser_info);

    	echo $new_data->browserName;
    }


    public function index()
    {
    	//$all_ip_data = UserTrace::all();

    	return view('admin.activities.iplist');
    }


    public function listdata(){

        DB::statement(DB::raw('set @rownum=0'));
        $ip_list_all = UserTrace::get(['user_traces.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        return DataTables::of($ip_list_all)
            ->addColumn('action', function ($single_ip) {
                $col_to_show = '<a href="#" class="btn btn-primary" id="userLocationModalSwitch" data-id='.$single_ip->user_id.'><i class="fa fa-eye"></i></a>';
                return $col_to_show;
            })
            ->addColumn('student_id',function($single_ip){
                return $single_ip->user->student_id;
            })
            ->addColumn('user_ip',function($single_ip){
                return $single_ip->user_ip;
            })
            ->addColumn('location_info',function($single_ip){
                return $single_ip->getLocationInfo();
            })
            ->addColumn('device_info',function($single_ip){
                return $single_ip->getDeviceInfo();
            })
            ->rawColumns(['location_info','device_info','action'])
            ->make(true);
    }

    public function locationByUserId(Request $request)
    {	
        //dd($request->all());
        $ip_lists = UserTrace::with('user')->where('user_id',$request->id)->orderBy('id','desc')->get();
    	$activity = Activity::where('causer','user')->where('causer_id',$request->id)->limit(500)->orderBy('id','desc')->get();
    	return ['ip_lists'=>$ip_lists,'activity'=>$activity];
    }
}


