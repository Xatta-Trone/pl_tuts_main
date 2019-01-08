<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\loginDetails;
use App\Model\Admin\Userdata;
use App\Model\User\User;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        //return $request->all();
        $this->validator($request->all())->validate();
        $validated_data  = $this->validateUserData($request->all());
        $validated_data =  (array) $validated_data;
        //dd($validated_data);
        if($validated_data['message'] == 'duplicate'){
            $hall_names = DB::table('userdatas')->distinct()->get(['hall_name']);
            return view('user.register')->with('custom_error', 'There is a user already with this student id')->with('hall_names',$hall_names);
        }
        elseif ($validated_data['message'] == 'false') {
           $hall_names = DB::table('userdatas')->distinct()->get(['hall_name']);
            return view('user.register')->with('custom_error', 'We did not found any match with provided data. Please provide correct data.')->with('hall_names',$hall_names);
        }else{
            
            event(new Registered($user = $this->create($validated_data)));

             //$this->guard()->login($user);
             return redirect()->route('checkemail');

             return $this->registered($request, $user)
                             ?: redirect($this->redirectPath());
        }
        
    }

    public function validateUserData($data){
        $name = $data['name'];
        $email = $data['email'];
        $student_id = $data['student_id'];
        $merit = $data['type'].sprintf("%04d",$data['merit_position']);
        $hall_name = $data['hall_name'];
        //dd($hall_name);exit;

        if (!$this->checkExistingUser($student_id)) {

            $userDataFromDB = DB::table('userdatas')->where([['student_id','=',$student_id],['merit','=',$merit],['hall_name','=',$hall_name]])->orWhere([['student_id','=',$student_id],['merit','=',$merit],['student_name','like','%'.$name.'%']])->get()->first();
            //dd($userDataFromDB);exit;

            if ($userDataFromDB != NULL) {
                $userDataFromDB->email = $email;
                $userDataFromDB->password = Str::random(8);
                $userDataFromDB->message = 'true';
                return $userDataFromDB;
            }else{
                $userDataFromDB = (object) array('message'=>'false');
                return $userDataFromDB;
            }
        }else{
            $userDataFromDB = (object) array('message'=>'duplicate');
            return $userDataFromDB;
        }
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'hall_name' => 'required',
            'student_id' => 'required',
            'merit_position' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       // dd($data);
        $userData =  User::create([
            'name' => $data['student_name'],
            'email' => $data['email'],
            'student_id' => substr($data['student_id'],3),
            'status' => 1,
            'user_letter' => substr($this->userLetter($data['student_name']),0,1),
            'password' => bcrypt($data['password']),
        ]);
        //dd($userData);
        //$user = User::findOrFail($userData->id);
        //$user = User::findOrFail($userData->id);
        $user = $userData;
        $user->password = $data['password'];
        $this->sendEmail($user);
        $this->setUserDataStatus($data['id']);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        SEOMeta::setTitle('Register');
        OpenGraph::setTitle('Register');
        $hall_names = DB::table('userdatas')->distinct()->get(['hall_name']);
        return view('user.register')->with('hall_names',$hall_names);
    }
    public function sendEmail($user){
        Mail::to($user['email'])->send(new loginDetails($user));
    }

    public function checkemail(){
        return view('user.checkemail');
    }
    public function setUserDataStatus($user){
        $user = Userdata::find($user);
        $user->status = 1;
        $user->save();
    }

    public function checkExistingUser($student_id){
        $student_id = $this->studentIdWithoutPrefix($student_id);
        //dd($student_id);
        $result = DB::table('users')->where('student_id',$student_id)->get()->count();
        if ($result > 0) {
           return true;
        }else{
            return false;
        }
    }


    public function studentIdWithoutPrefix($student_id){
        $student_id = strtolower($student_id);
        return (substr($student_id,0,1) == 's') ? substr($student_id,3) : $student_id;
    }

    public function userLetter($name = ''){
        $array = explode(" ",$name);
        if(count($array) == 1){
            return $array[0];
        }elseif($array[0] != 'Md' && $array[0] != 'Md.' && $array[0] != 'Mohammad'){
            return $array[0];
        }
        else{
            return $array[1];
        }
    }


}
