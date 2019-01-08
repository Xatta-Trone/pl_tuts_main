<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Book;
use App\Model\Admin\Post;
use App\Model\Admin\Software;
use App\Model\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmailAvailable extends Controller
{
    function check(Request $request)
    {
    	//return $request->all();exit;

    	$email = User::where('email',$request->email)->get();

    	return $email->count();
    }

    public function getSearchData(Request $request){
    	//return $request->all();
    	switch ($request->post_type) {
    		case 'post':
    			$result = Post::find($request->id);
    			return $result;
    			break;
    		case 'book':
    			$result = Book::find($request->id);
    			return $result;
    			break;
    		case 'software':
    			$result = Software::find($request->id);
    			return $result;
    			break;
    		
    		default:
    			return false;
    			break;
    	}
    }

    public function customPasswordChange(Request $request){
       // return $request->all();
        $message = [];
        $old_password = $request->old_password;


        if (!(Hash::check($old_password, Auth::user()->password))) {
            $message['message'] = 'old password do not match';
            $message['success'] = 'false';
            return $message;

        }

        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            $message['message'] = 'new password can not be same as old password';
            $message['success'] = 'false';
            return $message;
        }

        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        $message['message'] = 'password changed successfully.';
        $message['success'] = 'true';

        return $message;

    }

    public function save(Request $request){
        //label is for searching
        //return $request->all();
        $activity_to_log = new Activity;

        $activity_to_log->causer = $request->causer;
        $activity_to_log->causer_id = $request->causer_id;
        $activity_to_log->activity = $request->activity;
        $activity_to_log->model = ucfirst($request->model);
        $activity_to_log->model_id = $request->model_id;
        $activity_to_log->label = $request->label;
        $activity_to_log->save();
        return 'ok';
    }
    
}
