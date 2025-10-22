<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringApprovalRequest extends Model
{
    protected $fillable = [
        'application_id',
        'approval_number',
        'salary_offered',
        'position_title',
        'department',
        'join_date',
        'briefing_date',
        'employment_type',
        'contract_duration_months',
        'benefits_package',
        'additional_notes',
        'approver_id',
        'status',
        'rejection_reason',
        'revision_notes',
        'approved_at',
        'rejected_at',
        'approval_document_path',
        'requested_by',
    ];

    protected $casts = [
        'join_date' => 'date',
        'briefing_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'salary_offered' => 'decimal:2',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function offerLetter()
    {
        return $this->hasOne(OfferLetter::class, 'approval_request_id');
    }

    public static function generateApprovalNumber()
    {
        $date = now();
        $prefix = 'APR';
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        
        $lastRequest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', $day)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastRequest ? (int)substr($lastRequest->approval_number, -3) + 1 : 1;
        
        return sprintf('%s-%s%s%s-%03d', $prefix, $year, $month, $day, $sequence);
    }

    public function approve($userId = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // TODO: Send notification to HR
    }

    public function reject($reason, $userId = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'rejected_at' => now(),
        ]);

        // TODO: Send notification to HR
    }

    public function requestRevision($notes, $userId = null)
    {
        $this->update([
            'status' => 'revision_needed',
            'revision_notes' => $notes,
        ]);

        // TODO: Send notification to HR
    }
}
