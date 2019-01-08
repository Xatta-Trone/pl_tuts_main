<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WatchList extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\Model\User\User');
    }

    public function totalIp($id)
    {
    	$total_IP = DB::table('user_traces')->where('user_id',$id)->get()->count();
    	return $total_IP;
    }
}
