<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuClinic extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'phone_alt',
        'email',
        'map_link',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function schedules()
    {
        return $this->hasMany(MedicalCheckupSchedule::class, 'clinic_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
