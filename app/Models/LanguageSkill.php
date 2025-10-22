<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageSkill extends Model
{
    protected $table = 'language_skills';
    protected $fillable = ['user_id', 'language', 'writing', 'reading', 'grammar', 'notes'];
}
