<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonFormalEducation extends Model
{
    protected $table = 'non_formal_educations';
    protected $fillable = ['user_id', 'name', 'place', 'period', 'notes'];
}
