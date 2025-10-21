<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantIdentity extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'birth_place',
        'birth_date',
        'national_id_number',
        'driving_license_types',
        'driving_license_number',
        'phone_number',
        'address_ktp',
        'address_domicile',
        'parent_phone',
        'email',
        'religion',
        'gender',
        'blood_type',
        'height_cm',
        'weight_kg',
        'shirt_size',
        'pants_size',
        'shoe_size',
        'photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'driving_license_types' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
