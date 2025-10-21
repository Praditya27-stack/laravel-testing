<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStage extends Model
{
    protected $fillable = [
        'application_id',
        'stage_name',
        'stage_order',
        'status',
        'notes',
        'rejection_reason',
        'documents_requested',
        'started_at',
        'completed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'documents_requested' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Stage names mapping
    public static function getStageNames()
    {
        return [
            'administrative' => 'Administrative Selection',
            'psychotest' => 'Psychotest',
            'hr_interview' => 'HR Interview',
            'user_interview' => 'User Interview',
            'background_check' => 'Background Check',
            'mcu' => 'Medical Checkup',
            'offering' => 'Hiring Approval',
        ];
    }

    // Get stage display name
    public function getStageDisplayNameAttribute()
    {
        $names = self::getStageNames();
        return $names[$this->stage_name] ?? $this->stage_name;
    }

    // Check if stage is completed
    public function isCompleted()
    {
        return in_array($this->status, ['passed', 'failed']);
    }

    // Mark as passed
    public function markAsPassed($reviewerId, $notes = null)
    {
        $this->update([
            'status' => 'passed',
            'completed_at' => now(),
            'reviewed_by' => $reviewerId,
            'notes' => $notes,
        ]);
    }

    // Mark as failed
    public function markAsFailed($reviewerId, $reason, $notes = null)
    {
        $this->update([
            'status' => 'failed',
            'completed_at' => now(),
            'reviewed_by' => $reviewerId,
            'rejection_reason' => $reason,
            'notes' => $notes,
        ]);
    }
}
