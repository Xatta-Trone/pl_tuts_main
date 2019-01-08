<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function levelterms()
    {
        return $this->hasMany('App\Model\Admin\LevelTerm');
    }

    public function courses()
    {
        return $this->hasMany('App\Model\Admin\Course');
    }
    public function getRouteKeyName(){
    	return 'slug';
    }




}
