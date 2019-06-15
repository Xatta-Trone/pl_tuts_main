<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTAuthException;
class UserController extends Controller
{   
    private $user;
    public function __construct(User $user){
        $this->user = $user;
        
        $this->middleware('jwt.auth')->only(['getAuthenticatedUser','refreshToken','sss']);
    }
   
    public function register(Request $request){

        $user = $this->user->create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);

        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }
    
    public function login(Request $request){
        // return $request->all();

        $credentials = $request->only('email', 'password');

        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['invalid_email_or_password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }

        // $refreshToken = JWTAuth::refresh($token);
        $user = JWTAuth::toUser($token);


        return response()->json(['token'=>$token,'user'=> $user]);
    }


    public function getAuthUser(Request $request){
        $user = JWTAuth::toUser($request->token);

        return response()->json($user);
    }


    public function sss()
    {
       //  $token = JWTAuth::getToken();
       //  $user = JWTAuth::authenticate($token);
       // $u =  Auth::login($user, false);
       return auth()->user()->name;
        // $user = JWTAuth::parseToken()->authenticate()
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // $id = Auth::user()

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function refreshToken()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return response()->json(['token'=>$newToken]);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        $status =  JWTAuth::invalidate(JWTAuth::getToken());

        if($status){
            return response('true');
        }
        return response('false');
    }

    public function resetpassword(Request $request)
    {
        return $request->all();
    }
}