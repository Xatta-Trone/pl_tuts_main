<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle($request, Closure $next)
    // {

    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {

        // $response = $next($request);
        // $response = $response instanceof RedirectResponse ? $response : response($response);


        try{
            $token = ($request->bearerToken() == null) ? $request->input('token'): $request->bearerToken();
            // $token = $request->input('token');
            // $user = JWTAuth::toUser($request->input('token'));
            $user = JWTAuth::authenticate($token);
            Auth::login($user, false);
            // $response->header('token', $token);
            // $user = JWTAuth::parseToken()->authenticate()

        }catch (JWTException $e) {

            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['token_expired'], $e->getStatusCode());
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['token_invalid'], $e->getStatusCode());
            }else{
                return response()->json(['error'=>'Token is required']);
            }
        }
       return $next($request);
    }
}
