<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class ProtectRouteByCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Request::is('departments/*'))
        {
            $current_url = $request->path();
            // dd($current_url);
            $segments    = explode('/', $current_url);
            // $dept_prefix = $segments[0];
            $dept        = $segments[1];
            // $level_term  = $segments[2];
            // $course      = $segments[3];

            $student_id = substr(Auth::guard('web')->user()->student_id,2,2);
            $user_dept  = $this->returnDeptString($student_id);

            if(strtoupper($dept) == $user_dept)
            {
                return $next($request);
            }
            elseif($user_dept == "WRE" && strtoupper($dept) == "CE")
            {
                return $next($request);
            }
            else
            {
                return redirect()->route('departments')->with('warning','You are not authorized to access that page. <br> You can only browse your departments pages.');
            }

            
            // return $next($request);

        }
        

        
    }

    public function returnDeptString($dept = ''){
        $dept = substr($dept,0,2);

        $single_department = DB::table('departments')->where('dept_code',$dept)->first();

        $dept_status_or_slug = ($single_department != NULL) ? strtoupper($single_department->slug) : 'Not Found';

        return $dept_status_or_slug;


        //return $batch.'+'.$dept;
    }
}
