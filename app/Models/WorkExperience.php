<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $table = 'work_experiences';
    protected $fillable = ['user_id', 'company', 'position', 'salary', 'period', 'reason'];
}
