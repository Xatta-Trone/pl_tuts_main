<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function department(){
    	 return $this->belongsTo('App\Model\Admin\Department','department_id');
    }
    public function levelterm(){
    	 return $this->belongsTo('App\Model\Admin\LevelTerm','level_term_id');
    }
    public function posts(){
    	return $this->hasMany('App\Model\Admin\Post');
    }

    public function separator($str){
    	$arr = preg_replace('/[a-z](?=\\d)/i', '$0 ', $str);;
    	$arr = explode(' ', $arr);
    	return $arr[0].'-'.$arr[1];
    }
    
}
