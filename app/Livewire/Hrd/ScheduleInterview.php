<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Job;
use App\Models\ApplicationStage;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ScheduleInterview extends Component
{
    public $job_id;
    public $stage;
    public $job;
    
    // Selected candidates
    public $selectedCandidates = [];
    public $selectAll = false;
    
    // Step tracking
    public $currentStep = 1; // 1: Select, 2: Details, 3: Preview
    
    // Interview details
    public $interviewType = 'user_interview';
    public $interviewerId;
    public $scheduledDate;
    public $scheduledTime;
    public $durationMinutes = 60;
    public $mode = 'onsite';
    public $location;
    public $zoomLink;
    public $phoneNumber;
    public $preparationNotes;
    
    // Preview
    public $emailSubject;
    public $emailBody;

    protected $rules = [
        'selectedCandidates' => 'required|array|min:1',
        'interviewType' => 'required|in:hr_interview,user_interview',
        'interviewerId' => 'required|exists:users,id',
        'scheduledDate' => 'required|date|after:today',
        'scheduledTime' => 'required',
        'durationMinutes' => 'required|integer|min:30|max:180',
        'mode' => 'required|in:onsite,zoom,phone',
    ];

    public function mount($job_id, $stage)
    {
        $this->job_id = $job_id;
        $this->stage = $stage;
        $this->job = Job::findOrFail($job_id);
        
        // Determine interview type based on stage
        if ($stage === 'hr_interview') {
            $this->interviewType = 'hr_interview';
        } else {
            $this->interviewType = 'user_interview';
        }
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
        return ApplicationStage::with(['application.user', 'application.applicantIdentity'])
            ->where('stage_name', $this->stage)
            ->whereHas('application', function($q) {
                $q->where('job_id', $this->job_id);
            })
            ->where('status', 'passed')
            ->get();
    }

    public function getInterviewers()
    {
        // Get users with interviewer or hr_recruiter role
        return User::role(['interviewer', 'hr_recruiter', 'admin'])->get();
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate(['selectedCandidates' => 'required|array|min:1']);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'interviewType' => 'required',
                'interviewerId' => 'required',
                'scheduledDate' => 'required|date|after:today',
                'scheduledTime' => 'required',
                'mode' => 'required',
            ]);
            
            // Validate mode-specific fields
            if ($this->mode === 'onsite') {
                $this->validate(['location' => 'required']);
            } elseif ($this->mode === 'zoom') {
                $this->validate(['zoomLink' => 'required|url']);
            } elseif ($this->mode === 'phone') {
                $this->validate(['phoneNumber' => 'required']);
            }
            
            $this->preparePreview();
        }
        
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function preparePreview()
    {
        $interviewTypes = Interview::getInterviewTypes();
        $modes = Interview::getModes();
        
        $scheduledDateTime = $this->scheduledDate . ' ' . $this->scheduledTime;
        
        // Email template
        $this->emailSubject = "Undangan Interview - {$this->job->vacancy_title}";
        $this->emailBody = "Selamat! Anda telah lolos tahap sebelumnya.\n\n";
        $this->emailBody .= "Kami mengundang Anda untuk mengikuti {$interviewTypes[$this->interviewType]}:\n\n";
        $this->emailBody .= "📅 Jadwal: {$scheduledDateTime}\n";
        $this->emailBody .= "⏱️ Durasi: {$this->durationMinutes} menit\n";
        $this->emailBody .= "📍 Mode: {$modes[$this->mode]}\n";
        
        if ($this->mode === 'onsite') {
            $this->emailBody .= "🏢 Lokasi: {$this->location}\n";
        } elseif ($this->mode === 'zoom') {
            $this->emailBody .= "🔗 Zoom Link: {$this->zoomLink}\n";
        } elseif ($this->mode === 'phone') {
            $this->emailBody .= "📞 Nomor: {$this->phoneNumber}\n";
        }
        
        if ($this->preparationNotes) {
            $this->emailBody .= "\n📝 Catatan Persiapan:\n{$this->preparationNotes}\n";
        }
    }

    public function scheduleInterviews()
    {
        $this->validate();

        $scheduledDateTime = $this->scheduledDate . ' ' . $this->scheduledTime;
        $scheduledCount = 0;

        foreach ($this->selectedCandidates as $stageId) {
            $stage = ApplicationStage::with('application')->find($stageId);
            
            if (!$stage) continue;

            // Create interview
            Interview::create([
                'application_id' => $stage->application_id,
                'job_id' => $this->job_id,
                'interview_type' => $this->interviewType,
                'interviewer_id' => $this->interviewerId,
                'scheduled_at' => $scheduledDateTime,
                'duration_minutes' => $this->durationMinutes,
                'mode' => $this->mode,
                'location' => $this->mode === 'onsite' ? $this->location : null,
                'zoom_link' => $this->mode === 'zoom' ? $this->zoomLink : null,
                'phone_number' => $this->mode === 'phone' ? $this->phoneNumber : null,
                'preparation_notes' => $this->preparationNotes,
                'status' => 'scheduled',
            ]);

            // TODO: Send email and calendar invite
            
            $scheduledCount++;
        }

        session()->flash('success', "✅ Berhasil menjadwalkan {$scheduledCount} interview!");
        
        return redirect()->route('hrd.recruitment.stage', [
            'job_id' => $this->job_id,
            'stage' => $this->stage
        ]);
    }

    public function render()
    {
        $candidates = $this->getCandidates();
        $interviewers = $this->getInterviewers();
        $interviewTypes = Interview::getInterviewTypes();
        $modes = Interview::getModes();
        
        return view('livewire.hrd.schedule-interview', [
            'candidates' => $candidates,
            'interviewers' => $interviewers,
            'interviewTypes' => $interviewTypes,
            'modes' => $modes,
        ]);
    }
}
