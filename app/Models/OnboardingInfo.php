<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingInfo extends Model
{
    protected $fillable = [
        'application_id',
        'offer_letter_id',
        'onboarding_date',
        'onboarding_time',
        'onboarding_location',
        'required_documents',
        'onboarding_agenda',
        'contact_person',
        'status',
        'info_sent_at',
        'onboarded_at',
        'is_archived',
    ];

    protected $casts = [
        'onboarding_date' => 'date',
        'required_documents' => 'array',
        'info_sent_at' => 'datetime',
        'onboarded_at' => 'datetime',
        'is_archived' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function offerLetter()
    {
        return $this->belongsTo(OfferLetter::class, 'offer_letter_id');
    }

    public function getDefaultRequiredDocuments()
    {
        return [
            'KTP Asli & Fotocopy',
            'Kartu Keluarga Asli & Fotocopy',
            'Ijazah Terakhir Asli & Fotocopy',
            'Transkrip Nilai Asli & Fotocopy',
            'SKCK (Surat Keterangan Catatan Kepolisian)',
            'Pas Foto 3x4 (3 lembar)',
            'NPWP (jika ada)',
            'Buku Tabungan (untuk gaji)',
            'Surat Keterangan Sehat dari Dokter',
        ];
    }

    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'info_sent_at' => now(),
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'onboarded_at' => now(),
        ]);
    }

    public function archive()
    {
        $this->update([
            'is_archived' => true,
        ]);
    }
}
