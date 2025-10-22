<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantReference extends Model
{
    protected $table = 'applicant_references';
    
    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'company',
        'position',
        'phone',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
