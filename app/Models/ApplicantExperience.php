<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantExperience extends Model
{
    protected $table = 'applicant_experiences';
    
    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'job_description',
        'start_date',
        'end_date',
        'is_current',
        'reason_leaving',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
