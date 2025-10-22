<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantStrengthsWeaknesses extends Model
{
    protected $fillable = ['user_id', 'strengths', 'weaknesses'];
}
