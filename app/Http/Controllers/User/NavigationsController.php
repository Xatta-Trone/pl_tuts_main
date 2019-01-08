<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Admin\Course;
use App\Model\Admin\Department;
use App\Model\Admin\LevelTerm;
use App\Model\Admin\Post;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NavigationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['departments']);
    }

    public function navUrl($dept,$level_term=null,$course=null){
        if($course != null){
            $data = Course::with('posts')->where('slug',$course)->get()->first();
            //dd($data);

            $descriptions = [];
            //self description
            $description[] = $data->description;
            //all course description
            foreach ($data->posts as $p) {
                $description[] = $p->description;
            }
            //dd(implode(' ', $description));
            //dd($description);

            SEOMeta::setTitle(strtoupper($data->separator($data->slug)).'('.$data->course_name.')');
            SEOMeta::addKeyword(implode(',', $description));
            SEOMeta::setDescription(implode(' ', $description));

            OpenGraph::setTitle(strtoupper($data->separator($data->slug)).'('.$data->course_name.')');
            OpenGraph::setDescription(implode(' ', $description));
            OpenGraph::addProperty('type', 'article');

            return view('user.course')->with('data',$data);
        }
    	elseif ($level_term != null) {
            $dept_id = DB::table('departments')->where('slug',$dept)->first();
            $dept_slug = $dept_id->slug;
            $dept_id = $dept_id->id;
            //dd($dept_id);
    		$data = LevelTerm::with(['course','department'])->where([['slug','=',$level_term],['department_id','=',$dept_id]])->get()->first();
    		//dd($data);
            $posts = Post::where([['department_slug','=',$dept_slug],['level_term_slug','=',$level_term],['course_id','=',NULL],['status','=',1]])->get();
            //dd($posts);

            $descriptions = [];
            //all department description
            $description[] = $data->description;
            $description[] = $data->department->description;
            //all course description
            foreach ($data->course as $c) {
                $description[] = $c->description;
            }
            foreach ($posts as $post) {
                $description[] = $post->description;
            }
            //dd(implode(' ', $description));
            //dd($description);

            SEOMeta::setTitle($data->name);
            SEOMeta::addKeyword(implode(',', $description));
            SEOMeta::setDescription(implode(' ', $description));

            OpenGraph::setTitle($data->name);
            OpenGraph::setDescription(implode(' ', $description));
            OpenGraph::addProperty('type', 'article');

            return view('user.level_term')->with('data',$data)->with('posts',$posts);
    	}else{

    		$data = Department::with('levelterms')->where('slug',$dept)->get()->first();
            //seo data
            $descriptions = [];
            //all level term description
            $description[] = $data->description;
            foreach ($data->levelterms as $levelterm) {
               $description[] = $levelterm->description;
            }
            //all course description
            foreach ($data->courses as $course) {
                $description[] = $course->description;
            }
            //dd(implode(' ', $description));

            SEOMeta::setTitle($data->dept_name);
            SEOMeta::addKeyword(implode(',', $description));
            SEOMeta::setDescription(implode(' ', $description));

            OpenGraph::setDescription(implode(' ', $description));
            OpenGraph::setTitle($data->dept_name);
            OpenGraph::addProperty('type', 'article');

            OpenGraph::addImage(config('app.url').Storage::url('/departments/'.$data->image));

            return view('user.ce')->with('dept',$data);
    	}
    }

    public function departments(){
        $departments = Department::orderBy('slug','asc')->get();
        return view('user.departments')->with('departments',$departments);
    }


}
