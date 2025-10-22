<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationExperience extends Model
{
    protected $table = 'organization_experiences';
    protected $fillable = ['user_id', 'name', 'place', 'position', 'period'];
}
