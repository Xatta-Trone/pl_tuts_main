<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Userdata extends Model
{
     protected $fillable  = ['merit', 'student_id', 'student_name', 'hall_name','status'];
}
