<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Application;
use App\Models\MedicalCheckupResult;
use App\Models\MedicalCheckupSchedule;

class InputMcuResult extends Component
{
    use WithFileUploads;

    public $applicationId;
    public $application;
    public $schedule;
    
    // File Upload
    public $resultFile;
    
    // Vital Signs
    public $blood_pressure;
    public $heart_rate;
    public $body_temperature;
    public $height;
    public $weight;
    public $bmi;
    
    // Vision & Hearing
    public $vision_left;
    public $vision_right;
    public $hearing_test;
    
    // Lab Tests
    public $blood_test_results;
    public $urine_test_results;
    public $xray_result;
    public $xray_notes;
    
    // Overall
    public $overall_fitness = 'pending';
    public $medical_notes;
    public $unfit_reason;
    public $result = 'pending';

    protected $rules = [
        'blood_pressure' => 'nullable|string',
        'heart_rate' => 'nullable|integer',
        'body_temperature' => 'nullable|numeric',
        'height' => 'nullable|numeric',
        'weight' => 'nullable|numeric',
        'vision_left' => 'nullable|string',
        'vision_right' => 'nullable|string',
        'hearing_test' => 'nullable|in:pass,fail,pending',
        'blood_test_results' => 'nullable|string',
        'urine_test_results' => 'nullable|string',
        'xray_result' => 'nullable|string',
        'xray_notes' => 'nullable|string',
        'overall_fitness' => 'required|in:fit,unfit,pending,need_retest',
        'medical_notes' => 'nullable|string',
        'unfit_reason' => 'required_if:result,unfit',
        'result' => 'required|in:fit,unfit,pending,need_retest',
        'resultFile' => 'nullable|file|mimes:pdf|max:10240',
    ];

    public function mount($applicationId)
    {
        $this->applicationId = $applicationId;
        $this->application = Application::with(['user', 'job', 'medicalCheckupSchedule', 'medicalCheckupResult'])
            ->findOrFail($applicationId);
        
        $this->schedule = $this->application->medicalCheckupSchedule;
        
        // Load existing result if any
        if ($this->application->medicalCheckupResult) {
            $result = $this->application->medicalCheckupResult;
            $this->fill($result->only([
                'blood_pressure', 'heart_rate', 'body_temperature',
                'height', 'weight', 'bmi',
                'vision_left', 'vision_right', 'hearing_test',
                'blood_test_results', 'urine_test_results',
                'xray_result', 'xray_notes',
                'overall_fitness', 'medical_notes', 'unfit_reason', 'result'
            ]));
        }
    }

    public function updatedHeightOrWeight()
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            $this->bmi = round($this->weight / ($heightInMeters * $heightInMeters), 2);
        }
    }

    public function updatedHeight()
    {
        $this->updatedHeightOrWeight();
    }

    public function updatedWeight()
    {
        $this->updatedHeightOrWeight();
    }

    public function saveResult()
    {
        $this->validate();

        $filePath = null;
        if ($this->resultFile) {
            $filePath = $this->resultFile->store('mcu-results', 'public');
        }

        $result = MedicalCheckupResult::updateOrCreate(
            ['application_id' => $this->applicationId],
            [
                'schedule_id' => $this->schedule?->id,
                'result_file_path' => $filePath ?? $this->application->medicalCheckupResult?->result_file_path,
                'blood_pressure' => $this->blood_pressure,
                'heart_rate' => $this->heart_rate,
                'body_temperature' => $this->body_temperature,
                'height' => $this->height,
                'weight' => $this->weight,
                'bmi' => $this->bmi,
                'vision_left' => $this->vision_left,
                'vision_right' => $this->vision_right,
                'hearing_test' => $this->hearing_test,
                'blood_test_results' => $this->blood_test_results,
                'urine_test_results' => $this->urine_test_results,
                'xray_result' => $this->xray_result,
                'xray_notes' => $this->xray_notes,
                'overall_fitness' => $this->overall_fitness,
                'medical_notes' => $this->medical_notes,
                'unfit_reason' => $this->unfit_reason,
                'result' => $this->result,
                'import_method' => 'manual',
                'assessed_by' => auth()->id(),
                'assessed_at' => now(),
                'result_date' => now(),
            ]
        );

        // Update schedule status
        if ($this->schedule) {
            $this->schedule->markAsCompleted();
        }

        // Handle result actions
        if ($this->result === 'fit') {
            $result->markAsFit($this->medical_notes, auth()->id());
            session()->flash('message', '✅ Candidate marked as FIT and moved to Hiring Approval!');
        } elseif ($this->result === 'unfit') {
            $result->markAsUnfit($this->unfit_reason, $this->medical_notes, auth()->id());
            session()->flash('message', '❌ Candidate marked as UNFIT. Application rejected.');
        } elseif ($this->result === 'need_retest') {
            $result->markAsNeedRetest($this->medical_notes, auth()->id());
            session()->flash('message', '⏳ Retest scheduled for candidate.');
        } else {
            session()->flash('message', '✅ MCU result saved successfully!');
        }

        return redirect()->route('hrd.medical-checkup.status');
    }

    public function render()
    {
        return view('livewire.hrd.input-mcu-result')->layout('layouts.hrd');
    }
}
