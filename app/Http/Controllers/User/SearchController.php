<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Course;
use App\Model\Admin\Department;
use App\Model\Admin\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','how_to','faq']);
    }
    public function index(){
    	return view('user.search');
    }
    public function result(Request $result){
        //return $result->all();

    	$departments = Department::orderBy('slug','asc')->get();
    	$level_terms = DB::table('level_terms')->distinct()->get(['slug']);
    	$courses = 	Course::distinct()->orderBy('slug','asc')->get(['slug']);
    	//return $level_terms;
        if(count($result->all()) == 0){
            $results = [];
         return view('user.search',compact('departments','level_terms','courses','results'));
        }

    	$query = Input::get('query');
    	$l_t = Input::get('l_t');
    	$dept = Input::get('dept');
    	$course = Input::get('course');
    	$content_type = Input::get('content_type');
    	//dd($query);

        if (!empty($query) || !empty($l_t) || !empty($dept) || !empty($course) || !empty($content_type)) {
            $softwares = DB::table('softwares')->select('*');
            $books = DB::table('books')->select('*');
            $posts = DB::table('posts')->select('*');
        }
        

				if($query != NULL){
					$posts->where('name','like',"%".$query."%")->orWhere('author','like',"%".$query."%")->orWhere('description','like',"%".$query."%");
					$books->where('name','like',"%".$query."%")->orWhere('author','like',"%".$query."%")->orWhere('description','like',"%".$query."%");
					$softwares->where('name','like',"%".$query."%")->orWhere('author','like',"%".$query."%")->orWhere('description','like',"%".$query."%");
					
				}
				if($l_t != null){
					$posts->where('level_term_slug',$l_t);
					$books->where('level_term_slug',$l_t);
					$softwares->where('level_term_slug',$l_t);
				}
				if($dept != null){
					$posts->where('department_slug',$dept);
					$books->where('department_slug',$dept);
					$softwares->where('department_slug',$dept);
				}
                if($content_type != null){
                    $posts->where('post_type',$content_type);
                    $books->where('post_type',$content_type);
                    $softwares->where('post_type',$content_type);
                }
				if($course != null){
                    $course_id = DB::table('courses')->select('id')->where('slug',$course)->first();
                    $course_id = $course_id->id;
                    //dd($course_id);
					$posts->where('course_id',$course_id);
					$books->where('course_id',$course_id);
					$softwares->where('course_id',$course_id);
				}
            if (!empty($query) || !empty($l_t) || !empty($dept) || !empty($course) || !empty($content_type)) {
                $results =  $posts->union($softwares)
                            ->union($books)->orderBy('created_at','desc');
                
                $results= $results->get();
                //dd($results);

                //pagination
                $results= $results->toArray();
                $page = Input::get('page', 1);
                $paginate = 25;
                $offSet = ($page * $paginate) - $paginate;
                $itemsForCurrentPage = array_slice($results, $offSet, $paginate, true);
                $results = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($results), $paginate, $page, ['path'  => $result->url(),'query' => $result->query(),]);


                //dd($results);
                //$results= $results->paginate(2);
            }else{
                $results = [];
            }

        //log search data 
        // if(!empty($query)){
        //     $this->save('user',Auth::user()->id,'searched','','',$query);
        // }
        // if(!empty($l_t)){
        //     $this->save('user',Auth::user()->id,'searched','','',$l_t);
        // }
        // if(!empty($dept)){
        //     $this->save('user',Auth::user()->id,'searched','','',$dept);
        // }
        // if(!empty($course)){
        //     $this->save('user',Auth::user()->id,'searched','','',$course);
        // }
        // if(!empty($content_type)){
        //     $this->save('user',Auth::user()->id,'searched','','',$content_type);
        // }

        $searchd_data = 'q='.$query.', l_t='.$l_t.', dept='.$dept.', course='.$course.', content_type='.$content_type;
        //dd($searchd_data);
        $this->save('user',Auth::user()->id,'searched','','',$searchd_data);


    	
    	//dd($results);
    	return view('user.search',compact('departments','level_terms','courses','results'));

    }


    public static function courseSlug($id){
        $course = DB::table('courses')->where('id',$id)->first();
        $str = $course->slug;
        $arr = preg_replace('/[a-z](?=\\d)/i', '$0 ', $str);;
        $arr = explode(' ', $arr);
        return strtoupper($arr[0].'-'.$arr[1]);
        //dd($course);
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
