<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundCheckResult extends Model
{
    protected $fillable = [
        'application_id',
        'response_id',
        'result',
        'hr_notes',
        'additional_info',
        'system_suggestion',
        'suggestion_reason',
        'assessed_by',
        'assessed_at',
    ];

    protected $casts = [
        'assessed_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function response()
    {
        return $this->belongsTo(BackgroundCheckResponse::class, 'response_id');
    }

    public function assessedBy()
    {
        return $this->belongsTo(User::class, 'assessed_by');
    }

    public function markAsPassed($notes = null, $userId = null)
    {
        $this->update([
            'result' => 'passed',
            'hr_notes' => $notes,
            'assessed_by' => $userId ?? auth()->id(),
            'assessed_at' => now(),
        ]);

        // Move application to next stage
        $this->application->update([
            'current_stage' => 'medical_checkup',
        ]);

        // Log stage change
        ApplicationStage::create([
            'application_id' => $this->application_id,
            'stage_name' => 'medical_checkup',
            'status' => 'pending',
            'started_at' => now(),
        ]);
    }

    public function markAsFailed($notes = null, $userId = null)
    {
        $this->update([
            'result' => 'failed',
            'hr_notes' => $notes,
            'assessed_by' => $userId ?? auth()->id(),
            'assessed_at' => now(),
        ]);

        // Reject application
        $this->application->update([
            'current_stage' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => 'Failed background check: ' . $notes,
        ]);
    }
}
