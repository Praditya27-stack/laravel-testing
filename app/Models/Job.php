<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'code',
        'title',
        'slug',
        'department',
        'location',
        'employment_type',
        'seniority',
        'description',
        'requirements',
        'responsibilities',
        'salary_range',
        'hiring_manager_id',
        'posted_at',
        'closing_at',
        'status',
        // Vacancy Management Fields
        'publish_date',
        'end_date',
        'vacancy_title',
        'position',
        'education_level',
        'category',
        'function',
        'company',
        'skills_required',
        'total_needed',
        'selection_type',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'closing_at' => 'datetime',
        'publish_date' => 'date',
        'end_date' => 'date',
        'skills_required' => 'array',
    ];

    public function hiringManager()
    {
        return $this->belongsTo(User::class, 'hiring_manager_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
