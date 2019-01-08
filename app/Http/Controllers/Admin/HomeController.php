<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start = Carbon::now()->subDays(30);

        for ($i = 0 ; $i <= 30; $i++) {
            $user_data_to_check[$start->copy()->addDays($i)->format('d-M')] = 0;
            $activity_data_to_check[$start->copy()->addDays($i)->format('d-M')] = 0;
            $download_data_to_check[$start->copy()->addDays($i)->format('d-M')] = 0;
            $dates[] = $start->copy()->addDays($i)->format('d-M');
        }

        //users data
        $users_to_check = DB::table('users')
                                    ->selectRaw('COUNT(`id`) AS total, DATE_FORMAT(`created_at`, "%d-%b") AS date_created')
                                    ->groupBy(DB::raw('DATE_FORMAT(`created_at`, "%d-%b")'))
                                    ->get()
                                    ->keyBy('date_created')
                                    ->toArray();

        foreach ($users_to_check as $user) {
            $users_array[$user->date_created] = $user->total; 
        }

        foreach ($users_array as $key => $value) {
           //echo $key.'='.$value;
            if (array_key_exists($key, $user_data_to_check)) {
                $user_data_to_check[$key] = $value;
            }else{
                $user_data_to_check[$key] = 0;
            }
        }
        $user_data_to_check =  array_values($user_data_to_check);

        //activities data
        $activities_to_check = DB::table('activities')
                                    ->selectRaw('COUNT(`id`) AS total, DATE_FORMAT(`created_at`, "%d-%b") AS date_created')
                                    ->groupBy(DB::raw('DATE_FORMAT(`created_at`, "%d-%b")'))
                                    ->get()
                                    ->keyBy('date_created')
                                    ->toArray();

        foreach ($activities_to_check as $activities) {
            $activities_array[$activities->date_created] = $activities->total; 
        }

        foreach ($activities_array as $key => $value) {
           //echo $key.'='.$value;
            if (array_key_exists($key, $activity_data_to_check)) {
                $activity_data_to_check[$key] = $value;
            }else{
                $activity_data_to_check[$key] = 0;
            }
        }
        $activity_data_to_check =  array_values($activity_data_to_check);

        //activities data
        $downloads_to_check = DB::table('activities')
                                    ->selectRaw('COUNT(`id`) AS total, DATE_FORMAT(`created_at`, "%d-%b") AS date_created')
                                    ->where('activity','=','downloaded')
                                    ->groupBy(DB::raw('DATE_FORMAT(`created_at`, "%d-%b")'))
                                    ->get()
                                    ->keyBy('date_created')
                                    ->toArray();
        //dd($downloads_to_check);
        foreach ($downloads_to_check as $downloads) {
            $downloads_array[$downloads->date_created] = $downloads->total; 
        }
        //dd($downloads_array);
        foreach ($downloads_array as $key => $value) {
           //echo $key.'='.$value;
            if (array_key_exists($key, $download_data_to_check)) {
                $download_data_to_check[$key] = $value;
            }else{
                $download_data_to_check[$key] = 0;
            }
        }
        $download_data_to_check =  array_values($download_data_to_check);

        //pie chart datas 
        $pieUserData = $this->getPieUserDataByBatchNDept();
        //dd($pieUserData);

        //dd($this->getPieUserDataByBatchNDept());





        // er por theke sob thakbe
        $agodate = Carbon::now()->subWeek()->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::now()->yesterday()->format('Y-m-d');
        //dd($yesterday);
        $new_user = DB::table('users')->Where('created_at','>',$now)->get()->count();
        $new_user_weekly = DB::table('users')->Where('created_at','>',$agodate)->get()->count();
        //$new_user = DB::table('users')->whereBetween('created_at',[$agodate,$now])->get()->count();
        //$new_contact = DB::table('contacts')->whereBetween('created_at',[$agodate,$now])->count();
        $new_contact = DB::table('contacts')->where('status',0)->count();
        $downloads = DB::table('activities')->where('activity','downloaded')->count();
        $unreplied_email = DB::table('contacts')->where('replied',0)->count();
        $total_activities = DB::table('activities')->count();
        $total_userdata = DB::table('userdatas')->count();
        //$total_dept = DB::table('departments')->count();
        $total_post = DB::table('posts')->where('status',1)->count();
        $total_soft = DB::table('softwares')->where('status',1)->count();
        $total_book = DB::table('books')->where('status',1)->count();
        $total_testimonial = DB::table('testimonials')->where('status',1)->count();
        $registerd_user = DB::table('users')->count();

        //dd($new_users);
        return view('admin.home',compact('new_user','new_contact','registerd_user','downloads','total_activities','unreplied_email','total_userdata','total_post','total_soft','total_book','total_testimonial','new_user_weekly'))
        ->with('dates',json_encode($dates,JSON_NUMERIC_CHECK))
        ->with('user_data_to_check',json_encode($user_data_to_check,JSON_NUMERIC_CHECK))
        ->with('download_data_to_check',json_encode($download_data_to_check,JSON_NUMERIC_CHECK))
        ->with('activity_data_to_check',json_encode($activity_data_to_check,JSON_NUMERIC_CHECK))
        ->with('pieUserData',$pieUserData);
    }


    public function MergeArraydata($dates_to_check,$datas_array){

        $test_data = array_intersect_key($dates_to_check, $datas_array);
        //dd($data_array);

        foreach ($datas_array as $key => $value) {
           //echo $key.'='.$value;
            if (array_key_exists($key, $dates_to_check)) {
                $dates_to_check[$key] = $value;
            }else{
                $dates_to_check[$key] = 0;
            }
        }
        return array_values($dates_to_check);
    }


    public function getPieUserDataByBatchNDept(){

        $pieUserDatas = DB::table('users')
                        ->selectRaw('substr(`student_id`,1,4) as total, count(`id`) as number')
                        ->where(DB::raw('substr(`student_id`,1,4)'),'<>','0000')
                        ->groupBy(DB::raw('substr(`student_id`,1,4)'))
                        ->orderBy('total','desc')
                        ->get();

        foreach ($pieUserDatas as $pieUser) {
            $pieUser->dept_batch = $this->returnDeptBatchString($pieUser->total);
        }

        return $pieUserDatas;

       // $rand_color = '#' . substr(md5(mt_rand()), 0, 6);

    }

    public function returnDeptBatchString($batchDept = ''){
        $batch = substr($batchDept,0,2);
        $dept = substr($batchDept,2,2);

        $single_department = DB::table('departments')->where('dept_code',$dept)->first();

        $dept_status_or_slug = ($single_department != NULL) ? strtoupper($single_department->slug) : 'Not Found';

        return $dept_status_or_slug."'".$batch;


        //return $batch.'+'.$dept;
    }
}
