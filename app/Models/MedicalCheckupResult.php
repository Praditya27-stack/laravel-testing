<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalCheckupResult extends Model
{
    protected $fillable = [
        'application_id',
        'schedule_id',
        'result_file_path',
        'blood_pressure',
        'heart_rate',
        'body_temperature',
        'height',
        'weight',
        'bmi',
        'vision_left',
        'vision_right',
        'hearing_test',
        'blood_test_results',
        'urine_test_results',
        'xray_result',
        'xray_notes',
        'overall_fitness',
        'medical_notes',
        'unfit_reason',
        'result',
        'result_date',
        'import_method',
        'imported_by_file',
        'assessed_by',
        'assessed_at',
    ];

    protected $casts = [
        'result_date' => 'date',
        'assessed_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function schedule()
    {
        return $this->belongsTo(MedicalCheckupSchedule::class, 'schedule_id');
    }

    public function assessedBy()
    {
        return $this->belongsTo(User::class, 'assessed_by');
    }

    public function retests()
    {
        return $this->hasMany(MedicalCheckupRetest::class, 'original_result_id');
    }

    public function calculateBMI()
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            $this->bmi = round($this->weight / ($heightInMeters * $heightInMeters), 2);
            $this->save();
        }
    }

    public function markAsFit($notes = null, $userId = null)
    {
        $this->update([
            'result' => 'fit',
            'overall_fitness' => 'fit',
            'medical_notes' => $notes,
            'assessed_by' => $userId ?? auth()->id(),
            'assessed_at' => now(),
            'result_date' => now(),
        ]);

        // Move application to hiring approval stage
        $this->application->update([
            'current_stage' => 'hiring_approval',
        ]);

        // Log stage change
        ApplicationStage::create([
            'application_id' => $this->application_id,
            'stage_name' => 'hiring_approval',
            'status' => 'pending',
            'started_at' => now(),
        ]);
    }

    public function markAsUnfit($reason, $notes = null, $userId = null)
    {
        $this->update([
            'result' => 'unfit',
            'overall_fitness' => 'unfit',
            'unfit_reason' => $reason,
            'medical_notes' => $notes,
            'assessed_by' => $userId ?? auth()->id(),
            'assessed_at' => now(),
            'result_date' => now(),
        ]);

        // Reject application
        $this->application->update([
            'current_stage' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => 'Medical checkup: ' . $reason,
        ]);
    }

    public function markAsNeedRetest($reason, $userId = null)
    {
        $this->update([
            'result' => 'need_retest',
            'overall_fitness' => 'need_retest',
            'assessed_by' => $userId ?? auth()->id(),
            'assessed_at' => now(),
        ]);

        // Create retest record
        MedicalCheckupRetest::create([
            'original_result_id' => $this->id,
            'application_id' => $this->application_id,
            'retest_reason' => $reason,
            'status' => 'scheduled',
            'requested_by' => $userId ?? auth()->id(),
        ]);
    }
}
