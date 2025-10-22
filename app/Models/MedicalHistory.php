<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'medical_histories';
    protected $fillable = ['user_id', 'disease', 'status', 'since', 'notes'];
}
