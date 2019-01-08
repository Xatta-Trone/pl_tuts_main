<?php

namespace App\Model\Admin;

use App\Model\Admin\Admin;
use App\Model\Admin\Post;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function getCauserName($type,$id){
    	//dd($id);
    	switch ($type) {
    		case 'admin':
    			$admin = Admin::find($id);
                //dd($admin->name);
    			return ($admin != null) ? $admin->name : 'Admin Deleted';
    			break;
    		case 'user':
                if ($id === 0) {
                    return 'Guest';
                }

    			$user = User::find($id);
    			return ($user != null) ? $user->name : 'User Deleted';
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    }

    public function getModelInfo($model,$id){
    	switch ($model) {
    		case 'Post':
    			$data  = Post::find($id);
    			//dd($data);
    			return ($data != null) ? $data->name : 'already deleted';
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    }

    public function activityInfo(){
        $model = ucfirst($this->model);
        $model_id = $this->model_id;
        //dd($model,$model_id);
        switch ($model) {
            case 'Post':
                $data =  Post::with('course')->where('id',$model_id)->first();
                //dd($data);
                echo $data->course->slug;
                break;
            
            default:
                return '';
                break;
        }
    }
}
