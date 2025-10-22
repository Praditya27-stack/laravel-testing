<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalCheckupSchedule extends Model
{
    protected $fillable = [
        'application_id',
        'clinic_id',
        'mcu_date',
        'mcu_time',
        'requirements',
        'status',
        'invitation_sent_at',
        'reminder_sent_at',
        'scheduled_by',
    ];

    protected $casts = [
        'mcu_date' => 'date',
        'requirements' => 'array',
        'invitation_sent_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function clinic()
    {
        return $this->belongsTo(McuClinic::class, 'clinic_id');
    }

    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function result()
    {
        return $this->hasOne(MedicalCheckupResult::class, 'schedule_id');
    }

    public function getDefaultRequirements()
    {
        return [
            'Puasa 8-12 jam sebelum MCU',
            'Membawa KTP Asli',
            'Membawa Email Undangan (print/digital)',
            'Datang tepat waktu sesuai jadwal',
            'Menggunakan pakaian yang nyaman',
            'Istirahat cukup malam sebelumnya',
        ];
    }

    public function sendReminder()
    {
        $this->update(['reminder_sent_at' => now()]);
        // TODO: Send actual reminder email/WhatsApp
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsNoShow()
    {
        $this->update(['status' => 'no_show']);
    }
}
