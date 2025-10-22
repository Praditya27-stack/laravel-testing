<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    protected $table = 'marital_statuses';
    protected $fillable = ['user_id', 'status_ktp', 'status_actual', 'date'];
}
