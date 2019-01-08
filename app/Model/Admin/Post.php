<?php

namespace App\Model\Admin;

use App\Model\Admin\Admin;
use App\Model\Admin\Course;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function course(){
    	return $this->belongsTo('App\Model\Admin\Course');
    }
    public function levelterm(){
    	return $this->belongsTo('App\Model\Admin\LevelTerm','level_term_slug','slug');
    }
    public function department(){
    	return $this->belongsTo('App\Model\Admin\Department','department_slug','slug');
    }
    public function separator($str){
    	$arr = preg_replace('/[a-z](?=\\d)/i', '$0 ', $str);;
    	$arr = explode(' ', $arr);
    	return $arr[0].'-'.$arr[1];
    }

    public function status($id){
        $post = Post::find($id);

        $status = $post->status;

        switch ($status) {
            case 1:
                return '<span class="label label-success">Online</span>';
                break;
            case 2:
                return '<span class="label label-warning">Pending</span>';
                break;
            case 3:
                return '<span class="label label-primary">Drafted</span>';
                break;
            case 4:
                return '<span class="label label-info">Private</span>';
                break;
            case 5:
                return '<span class="label label-danger">Rejected</span>';
                break;
            
            default:
                return '<span class="label label-info">Undefined</span>';
                break;
        }
    }

    public function uploader(){
        return Admin::find($this->user_id);
    }

    public function courseData(){
        return ($this->course_id) ? Course::find($this->course_id)->slug : '<span class="label label-info">Undefined</span>';
    }
}
