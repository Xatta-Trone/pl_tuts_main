<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class LevelTerm extends Model
{
    public function department(){
    	 return $this->belongsTo('App\Model\Admin\Department','department_id','id');
    }
    public function course(){
    	 return $this->hasMany('App\Model\Admin\Course');
    }

}
