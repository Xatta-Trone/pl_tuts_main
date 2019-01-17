<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\UserTracesController;
use App\Http\Controllers\Controller;
use App\Model\Admin\UserTrace;
use App\Model\Admin\WatchList;
use App\Model\User\User;
use Browser;
use GuzzleHttp;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->userLocationHistory = $userTrace;
    }


    public function showLoginForm()
    {
        return view('user.login');
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        //dd(bcrypt($request->password));
        $user = User::where('email',$request->email)->first();
        //dd($user);
        if ($user != null) {
            if ($user->status == 0) {
                return ['email'=>'inactive','password'=>'Your account is not active . Please contact admin.'];
            }else{

                return ['email'=>$request->email,'password'=>$request->password,'status'=>1];
            }
        }else{
            return ['email'=>'not_registered','password'=>'These credentials do not match our records.'];
        }


        //return $request->only($this->username(), 'password');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        //$errors = [$this->username() => trans('auth.failed')];
        $fields = $this->credentials($request);
        //dd($fields);
        if (($fields['email'] == 'inactive') || ($fields['email'] == 'not_registered')) {
           $errors = $fields['password'];
        }else{
            $errors = [$this->username() => trans('auth.failed')];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }



    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        // dd($request->ip());
        // $this->saveNewLocation('45.251.231.201');
        $this->saveNewLocation($request->ip());

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }




    // public function saveUserLocationInfo(){
    //     //authenticated user id
    //     $user_id = Auth::user()->id;
    //     $ip_address = \Request::ip(); //'45.251.231.201';

    //     $this->compareIpAddress($ip_address);
    //     // return ;
    //     //dd($this->decideUserIpStatus());

    // }

    /*
        decides if the new ip has to be saved or not (if not existed)
    */


    // public function compareIpAddress($ip_address)
    // {
    //     $browser_info = json_encode(Browser::detect());
    //     // $ip_addresses = DB::table('user_traces')
    //     //     ->select('user_ip')
    //     //     ->where('user_id',Auth::user()->id)
    //     //     ->where('user_ip',$ip_address)
    //     //     ->where('browser_info',$browser_info)
    //     //     ->get()->count();

    //    // $location_info = json_decode($ip_addresses->location_info);
    //     //$isp = $location_info->isp;
    //     //return $ip_addresses;
    //     //count total ip address data
    //     // if ($ip_addresses > 0) {
    //     //   return $this->decideUserIpStatus();
    //     //   //return 'excuted';
    //     // }

    //     return $this->saveNewLocation();

    //     //return $ip_addresses;
    // }

    /*
    Save new user location if not found

    */

    public function saveNewLocation($ip_address)
    {

        // $ip_address = \Request::ip();//  '45.251.231.201';
        // $ip_address = "103.94.135.201";
        $browser_info = json_encode(Browser::detect());

        $loc = file_get_contents("https://extreme-ip-lookup.com/json/".$ip_address);
            // echo $loc;
        $location_info = json_decode($loc);
        // dd($obj);

        // $client = new GuzzleHttp\Client();
        // $res = $client->get("http://ip-api.com/json/".$ip_address);

        // $location_info =  json_decode($res->getBody()); 
        // dd($res);



        if( $location_info->status === 'success')
        {


           // dd($location_info);

            $user_trace                = new UserTrace();
            $user_trace->user_id       = Auth::user()->id;
            $user_trace->user_ip       = $ip_address;
            $user_trace->is_allowed    = 1;
            $user_trace->location_info = json_encode($location_info); 
            $user_trace->browser_info  = $browser_info;

            $user_trace->save();

            // return 'new location saved';
        }
    }

    /*
        get all the ip address by fisrt 3 numner (ie 41.11.11 .333 is ignored in case of dynamic ip)
        decide if the user needs to be watched
    */

    // public function decideUserIpStatus(){
    //    $ip_addresses = DB::table('user_traces')
    //             ->selectRaw('substring_index(`user_ip`, \'.\', 3 ) as subip')
    //             ->where('user_id',Auth::user()->id)
    //             ->groupBy(DB::raw('substring_index( `user_ip`, \'.\', 3 )'))
    //             ->get()->count();
    //     if ($ip_addresses > 0) {
    //         return $this->addNewWatchListRecord();
    //     }
    //     return 'user not added in watchlist';
    // }

    // public function addNewWatchListRecord(){
    //     $user_id = Auth::user()->id;
    //     $added_by = 'self(system)';
    //     //determine if the user is already in watchlist
    //     $ifAlreadyInWatchlist = DB::table('watch_lists')->where('user_id',$user_id)->get()->count();
    //     if ($ifAlreadyInWatchlist > 0) {
    //         return 'already in watchlist';
    //     }
    //     $wathlist = new WatchList;
    //     $wathlist->user_id = $user_id;
    //     $wathlist->added_by = $added_by;
    //     $wathlist->save();

    //     return 'added new watchlist';
    // }




}
