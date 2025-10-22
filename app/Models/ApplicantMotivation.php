<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantMotivation extends Model
{
    protected $fillable = ['user_id', 'skills', 'reason_to_work', 'why_company', 'expected_salary', 'available_start_date', 'relative_name', 'relative_relation'];
}
