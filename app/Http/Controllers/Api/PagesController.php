<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\LevelTermResource;
use App\Http\Resources\SoftwareResource;
use App\Model\Admin\Activity;
use App\Model\Admin\Book;
use App\Model\Admin\Course;
use App\Model\Admin\Department;
use App\Model\Admin\LevelTerm;
use App\Model\Admin\Post;
use App\Model\Admin\Software;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Fractal\Fractal;

class PagesController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth')->except(['department','book']);
    }

    public function department()
    {
    	$departments = Department::orderBy('slug','asc')->get();
    	$res = fractal($departments, new DepartmentResource())->toArray();
    	return $res;
    }


    public function navUrl($dept,$level_term=null,$course=null){
        if($course != null){
            $data = Course::with('posts')->where('slug',$course)->get()->first();
            

            // return view('user.course')->with('data',$data);
            $res = fractal($data, new CourseResource())->toArray();
            return $res;
            // return $data;
        }
    	elseif ($level_term != null) {
            $dept_id = DB::table('departments')->where('slug',$dept)->first();
            $dept_slug = $dept_id->slug;
            $dept_id = $dept_id->id;
            //dd($dept_id);
    		$data = LevelTerm::with(['course','department'])->where([['slug','=',$level_term],['department_id','=',$dept_id]])->get()->first();
    		//dd($data);
            // $posts = Post::where([['department_slug','=',$dept_slug],['level_term_slug','=',$level_term],['course_id','=',NULL],['status','=',1]])->get();

            // return view('user.level_term')->with('data',$data)->with('posts',$posts);
            $res = fractal($data, new LevelTermResource())->toArray();
            return $res;
    	}else{

    		$data = Department::with('levelterms')->where('slug',$dept)->get()->first();

            // return view('user.ce')->with('dept',$data);
            // return $data;
            $res = fractal($data, new DepartmentResource())->toArray();
            return $res;
    	}
    }



    public function software()
    {
        $data  = Software::orderBy('id','desc')->get();

        // return $data;

        $res = fractal($data, new SoftwareResource())->toArray();
        return $res;
    }

    public function book()
    {
        $data  = Book::orderBy('id','desc')->get();

        // return $data;

        $res = fractal($data, new BookResource())->toArray();
        return $res;
    }


    public function activities()
    {
        $data  = Activity::where('causer','user')->where('causer_id',auth()->user()->id)->where('activity','downloaded')->orderBy('id','desc')->take(250)->get();

        // return $data;

        $res = fractal($data, new ActivityResource())->toArray();
        return $res;
    }
}
