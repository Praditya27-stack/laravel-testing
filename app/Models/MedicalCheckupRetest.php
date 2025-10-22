<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalCheckupRetest extends Model
{
    protected $fillable = [
        'original_result_id',
        'application_id',
        'retest_reason',
        'retest_scheduled_date',
        'status',
        'requested_by',
    ];

    protected $casts = [
        'retest_scheduled_date' => 'date',
    ];

    public function originalResult()
    {
        return $this->belongsTo(MedicalCheckupResult::class, 'original_result_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
