<?php

namespace App\Http\Trait;

use App\Model\Admin\Activity;

trait ActivityTrait
{
    /*
        @params $causer    = admin/user
        @params $causer_id = admin_id/user_id
        @params $activity  = added/deleted/updated/searched
        @params $model     = model name
        @params $model_id  = the id which is affected
        @params $label     = string | when there is no id to strore
    */
    protected function save($causer = null,$causer_id = null,$activity = null,$model = null,$model_id = null,$label = null){
        //label is for searching
        $activity_to_log = new Activity;

        $activity_to_log->causer = $causer;
        $activity_to_log->causer_id = $causer_id;
        $activity_to_log->activity = $activity;
        $activity_to_log->model = $model;
        $activity_to_log->model_id = $model_id;
        $activity_to_log->lable = $lable;
        $activity_to_log->save();
        return ;
    }
}
