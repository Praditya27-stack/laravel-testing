<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationReferee extends Model
{
    protected $fillable = [
        'application_id',
        'name',
        'relationship',
        'company',
        'position',
        'email',
        'phone',
        'phone_alt',
        'work_period_start',
        'work_period_end',
        'is_primary',
        'is_verified',
        'notes',
    ];

    protected $casts = [
        'work_period_start' => 'date',
        'work_period_end' => 'date',
        'is_primary' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function backgroundCheckRequests()
    {
        return $this->hasMany(BackgroundCheckRequest::class, 'referee_id');
    }

    public function getWorkDurationAttribute()
    {
        if (!$this->work_period_start || !$this->work_period_end) {
            return null;
        }

        return $this->work_period_start->diffInMonths($this->work_period_end) . ' months';
    }
}
