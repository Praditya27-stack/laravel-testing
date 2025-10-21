<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'application_id',
        'job_id',
        'interview_type',
        'interviewer_id',
        'scheduled_at',
        'duration_minutes',
        'mode',
        'location',
        'zoom_link',
        'phone_number',
        'preparation_notes',
        'ics_file_path',
        'status',
        'candidate_confirmed',
        'candidate_declined',
        'candidate_response_at',
        'reminder_sent_at',
        'completed_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'candidate_response_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'completed_at' => 'datetime',
        'candidate_confirmed' => 'boolean',
        'candidate_declined' => 'boolean',
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function assessment()
    {
        return $this->hasOne(InterviewAssessment::class);
    }

    // Helper Methods
    public static function getInterviewTypes()
    {
        return [
            'hr_interview' => 'HR Interview',
            'user_interview' => 'User Interview',
        ];
    }

    public static function getModes()
    {
        return [
            'onsite' => 'Onsite',
            'zoom' => 'Zoom/Online',
            'phone' => 'Phone Call',
        ];
    }

    public function markAsConfirmed()
    {
        $this->update([
            'candidate_confirmed' => true,
            'candidate_response_at' => now(),
            'status' => 'confirmed',
        ]);
    }

    public function markAsDeclined($reason = null)
    {
        $this->update([
            'candidate_declined' => true,
            'candidate_response_at' => now(),
            'status' => 'declined',
            'cancellation_reason' => $reason,
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function cancel($reason)
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
        ]);
    }
}
