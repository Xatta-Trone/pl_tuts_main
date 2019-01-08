<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExellTest extends Model
{
    protected $fillable  = ['merit', 'student_no', 'student_name', 'hall_name','status'];
}
