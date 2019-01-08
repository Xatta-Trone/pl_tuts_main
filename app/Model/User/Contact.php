<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name','email','subject','body','status','replied','replied_by'];
}


