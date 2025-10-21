<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PsychotestInvitation extends Model
{
    protected $fillable = [
        'application_id',
        'job_id',
        'education_level',
        'test_types',
        'test_location',
        'scheduled_at',
        'expires_at',
        'passing_grade',
        'unique_token',
        'test_link',
        'guide_pdf_path',
        'hotline_contact',
        'status',
        'sent_at',
        'opened_at',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'test_types' => 'array',
        'scheduled_at' => 'datetime',
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
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

    public function sessions()
    {
        return $this->hasMany(PsychotestSession::class, 'invitation_id');
    }

    public function results()
    {
        return $this->hasMany(PsychotestResult::class, 'invitation_id');
    }

    // Test Types by Education Level
    public static function getTestTypesByEducation($educationLevel)
    {
        if ($educationLevel === 'SMK') {
            return [
                'wpt' => 'Test WPT',
                'army_alpha' => 'Test Army Alpha',
                'papikostick' => 'Test Papikostick',
                'ssct' => 'Test SSCT',
                'kraeplin' => 'Test Kraeplin',
            ];
        }
        
        // D3/S1
        return [
            'inteligensi' => 'Tes Inteligensi',
            'kepribadian' => 'Tes Kepribadian',
            'perilaku_kerja' => 'Tes Perilaku Kerja',
        ];
    }

    // Generate unique token
    public static function generateToken()
    {
        return Str::random(32);
    }

    // Generate test link
    public function generateTestLink()
    {
        return url('/psychotest/take/' . $this->unique_token);
    }

    // Check if expired
    public function isExpired()
    {
        return now()->isAfter($this->expires_at);
    }

    // Mark as sent
    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    // Mark as opened
    public function markAsOpened()
    {
        if ($this->status === 'sent') {
            $this->update([
                'status' => 'opened',
                'opened_at' => now(),
            ]);
        }
    }

    // Mark as started
    public function markAsStarted()
    {
        $this->update([
            'status' => 'started',
            'started_at' => now(),
        ]);
    }

    // Mark as completed
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
