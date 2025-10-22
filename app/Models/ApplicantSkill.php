<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantSkill extends Model
{
    protected $fillable = [
        'user_id',
        'skill_name',
        'proficiency_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
