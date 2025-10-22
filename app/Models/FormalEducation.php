<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormalEducation extends Model
{
    protected $table = 'formal_educations';
    protected $fillable = ['user_id', 'level', 'school_name', 'major', 'graduation_year', 'place', 'math_avg', 'math_un'];
}
