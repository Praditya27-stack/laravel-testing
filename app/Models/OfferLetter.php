<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    protected $fillable = [
        'application_id',
        'approval_request_id',
        'offer_number',
        'offer_letter_content',
        'offer_letter_pdf_path',
        'status',
        'sent_at',
        'accepted_at',
        'declined_at',
        'decline_reason',
        'response_deadline',
        'reminder_count',
        'last_reminder_at',
        'generated_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
        'response_deadline' => 'date',
        'last_reminder_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function approvalRequest()
    {
        return $this->belongsTo(HiringApprovalRequest::class, 'approval_request_id');
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function onboardingInfo()
    {
        return $this->hasOne(OnboardingInfo::class, 'offer_letter_id');
    }

    public static function generateOfferNumber()
    {
        $date = now();
        $prefix = 'OFR';
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        
        $lastOffer = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', $day)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastOffer ? (int)substr($lastOffer->offer_number, -3) + 1 : 1;
        
        return sprintf('%s-%s%s%s-%03d', $prefix, $year, $month, $day, $sequence);
    }

    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'response_deadline' => now()->addDays(7),
        ]);

        // Update application stage
        $this->application->update([
            'current_stage' => 'hired',
        ]);
    }

    public function markAsAccepted()
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // TODO: Send onboarding info
    }

    public function markAsDeclined($reason)
    {
        $this->update([
            'status' => 'declined',
            'declined_at' => now(),
            'decline_reason' => $reason,
        ]);

        // Mark position still open
    }

    public function sendReminder()
    {
        $this->increment('reminder_count');
        $this->update(['last_reminder_at' => now()]);

        // TODO: Send reminder email/WhatsApp
    }
}
