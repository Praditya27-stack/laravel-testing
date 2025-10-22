<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Application;
use App\Models\McuClinic;
use App\Models\MedicalCheckupSchedule;

class ScheduleMedicalCheckup extends Component
{
    public $jobId;
    public $selectedCandidates = [];
    public $selectAll = false;
    
    // Schedule Details
    public $scheduleType = 'bulk'; // single or bulk
    public $mcuDate;
    public $mcuTime;
    public $clinicId;
    public $requirements = [];
    public $customRequirement = '';
    
    // Preview
    public $showPreview = false;

    protected $rules = [
        'selectedCandidates' => 'required|array|min:1',
        'mcuDate' => 'required|date|after:today',
        'mcuTime' => 'required',
        'clinicId' => 'required|exists:mcu_clinics,id',
    ];

    public function mount($jobId = null)
    {
        $this->jobId = $jobId;
        $this->loadDefaultRequirements();
    }

    public function loadDefaultRequirements()
    {
        $schedule = new MedicalCheckupSchedule();
        $this->requirements = $schedule->getDefaultRequirements();
    }

    public function addCustomRequirement()
    {
        if ($this->customRequirement) {
            $this->requirements[] = $this->customRequirement;
            $this->customRequirement = '';
        }
    }

    public function removeRequirement($index)
    {
        unset($this->requirements[$index]);
        $this->requirements = array_values($this->requirements);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCandidates = $this->getCandidates()->pluck('id')->toArray();
        } else {
            $this->selectedCandidates = [];
        }
    }

    public function getCandidates()
    {
        $query = Application::with(['user', 'job'])
            ->where('current_stage', 'medical_checkup')
            ->whereDoesntHave('medicalCheckupSchedule');

        if ($this->jobId) {
            $query->where('job_id', $this->jobId);
        }

        return $query->get();
    }

    public function openPreview()
    {
        $this->validate();
        $this->showPreview = true;
    }

    public function scheduleAll()
    {
        $this->validate();

        $successCount = 0;
        $failCount = 0;

        foreach ($this->selectedCandidates as $applicationId) {
            try {
                $application = Application::find($applicationId);
                
                if (!$application) {
                    $failCount++;
                    continue;
                }

                MedicalCheckupSchedule::create([
                    'application_id' => $application->id,
                    'clinic_id' => $this->clinicId,
                    'mcu_date' => $this->mcuDate,
                    'mcu_time' => $this->mcuTime,
                    'requirements' => $this->requirements,
                    'status' => 'scheduled',
                    'invitation_sent_at' => now(),
                    'scheduled_by' => auth()->id(),
                ]);

                // TODO: Send email & WhatsApp invitation

                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                \Log::error('MCU Schedule Error: ' . $e->getMessage());
            }
        }

        session()->flash('message', "✅ MCU scheduled! Success: {$successCount}, Failed: {$failCount}");
        
        return redirect()->route('hrd.medical-checkup.status');
    }

    public function getClinicsProperty()
    {
        return McuClinic::active()->get();
    }

    public function render()
    {
        $candidates = $this->getCandidates();
        
        return view('livewire.hrd.schedule-medical-checkup', [
            'candidates' => $candidates,
            'clinics' => $this->clinics,
        ])->layout('layouts.hrd');
    }
}
