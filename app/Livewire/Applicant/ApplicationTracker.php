<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use App\Models\Application;

class ApplicationTracker extends Component
{
    public $applicationId;
    public $application;
    public $stages = [];
    public $currentStageIndex = 0;

    public function mount($id)
    {
        $this->applicationId = $id;
        $this->application = Application::with([
            'user',
            'job',
            'stages',
            'psychotestInvitation',
            'interviews',
            'backgroundCheckRequests',
            'medicalCheckupSchedule',
            'offerLetter'
        ])->findOrFail($id);

        // Check if user owns this application
        if ($this->application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $this->loadStages();
    }

    public function loadStages()
    {
        $job = $this->application->job;

        // Define stages based on job selection type
        if ($job->selection_type === 'operator_smk') {
            $stageNames = [
                'administrative' => 'Administrative Selection',
                'psychotest' => 'Psychotest',
                'user_interview' => 'User Interview',
                'background_check' => 'Background Check',
                'medical_checkup' => 'Medical Checkup',
                'hiring_approval' => 'Hiring Approval',
                'hired' => 'Hired',
            ];
        } else {
            $stageNames = [
                'administrative' => 'Administrative Selection',
                'psychotest' => 'Psychotest',
                'hr_interview' => 'HR Interview',
                'user_interview' => 'User Interview',
                'background_check' => 'Background Check',
                'medical_checkup' => 'Medical Checkup',
                'hiring_approval' => 'Hiring Approval',
                'hired' => 'Hired',
            ];
        }

        $currentStage = $this->application->current_stage;
        $stageKeys = array_keys($stageNames);
        $this->currentStageIndex = array_search($currentStage, $stageKeys);

        foreach ($stageNames as $key => $name) {
            $stageData = $this->application->stages->where('stage_name', $key)->first();
            $index = array_search($key, $stageKeys);

            $status = 'pending';
            if ($index < $this->currentStageIndex) {
                $status = 'completed';
            } elseif ($index === $this->currentStageIndex) {
                $status = 'current';
            }

            if ($currentStage === 'rejected' && $index === $this->currentStageIndex) {
                $status = 'rejected';
            }

            $this->stages[] = [
                'key' => $key,
                'name' => $name,
                'status' => $status,
                'started_at' => $stageData?->started_at,
                'completed_at' => $stageData?->completed_at,
                'details' => $this->getStageDetails($key),
            ];
        }
    }

    public function getStageDetails($stageKey)
    {
        switch ($stageKey) {
            case 'psychotest':
                $invitation = $this->application->psychotestInvitation;
                if ($invitation) {
                    return [
                        'type' => 'psychotest',
                        'date' => $invitation->test_date,
                        'time' => $invitation->test_time,
                        'status' => $invitation->status,
                        'score' => $invitation->psychotestResult?->total_score,
                    ];
                }
                break;

            case 'hr_interview':
            case 'user_interview':
                $interview = $this->application->interviews()
                    ->where('interview_type', $stageKey === 'hr_interview' ? 'hr' : 'user')
                    ->first();
                if ($interview) {
                    return [
                        'type' => 'interview',
                        'date' => $interview->interview_date,
                        'time' => $interview->interview_time,
                        'location' => $interview->location,
                        'status' => $interview->status,
                    ];
                }
                break;

            case 'background_check':
                $bgc = $this->application->backgroundCheckRequests()->latest()->first();
                if ($bgc) {
                    return [
                        'type' => 'bgc',
                        'status' => $bgc->status,
                        'sent_at' => $bgc->sent_at,
                    ];
                }
                break;

            case 'medical_checkup':
                $mcu = $this->application->medicalCheckupSchedule;
                if ($mcu) {
                    return [
                        'type' => 'mcu',
                        'date' => $mcu->mcu_date,
                        'time' => $mcu->mcu_time,
                        'clinic' => $mcu->clinic->name,
                        'status' => $mcu->status,
                    ];
                }
                break;

            case 'hired':
                $offer = $this->application->offerLetter;
                if ($offer) {
                    return [
                        'type' => 'offer',
                        'status' => $offer->status,
                        'sent_at' => $offer->sent_at,
                        'accepted_at' => $offer->accepted_at,
                    ];
                }
                break;
        }

        return null;
    }

    public function render()
    {
        return view('livewire.applicant.application-tracker')->layout('layouts.landing');
    }
}
