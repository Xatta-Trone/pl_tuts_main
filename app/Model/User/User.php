<?php

namespace App\Model\User;

use App\Mail\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
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
        Mail::to($this->email)->send(new ResetPassword($token));
    }

    public function getAcronym(){
        $name = Auth::user()->name;
        $words = explode(" ", $name);
        //dd($words);
        $length  = count($words);

        if ($length == 1) {
            $name = $words[0];
        }elseif($length == 2){
            $name = $words[0];
        }elseif ($length >= 3) {
            $name = $words[1];
        }else{
            $name = $name;
        }
        
        return $name;
    }


    public function ipList()
    {
        return $this->HasMany('App\Model\Admin\UserTrace');
    }
}
