<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantHobby extends Model
{
    protected $fillable = ['user_id', 'hobbies', 'free_time_activity'];
}
