<?php

namespace App\Model\Admin;

use App\Mail\AdminResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class Admin extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','student_id','user_letter','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany('App\Model\Admin\Role','admin_role','admin_id','role_id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    //$role maybe string or collection
    public function hasRole($role){
        if (is_string($role)) {
           return $this->roles->contains('name',$role);
        }

        return !! $role->intersect($this->roles)->count();

    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        ///dd($token);
        //$this->notify(new ResetPasswordNotification($token));
        Mail::to($this->email)->send(new AdminResetPassword($token));
    }
}
