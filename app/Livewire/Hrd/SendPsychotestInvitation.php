<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Job;
use App\Models\ApplicationStage;
use App\Models\PsychotestInvitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SendPsychotestInvitation extends Component
{
    use WithFileUploads;

    public $job_id;
    public $stage = 'psychotest';
    public $job;
    
    // Selected candidates
    public $selectedCandidates = [];
    public $selectAll = false;
    
    // Step tracking
    public $currentStep = 1; // 1: Select, 2: Test Types, 3: Schedule, 4: Preview
    
    // Test configuration
    public $educationLevel;
    public $selectedTestTypes = [];
    public $testLocation = 'online';
    public $scheduledDate;
    public $scheduledTime;
    public $expiryDays = 2;
    public $passingGrade = 70;
    public $guidePdf;
    public $hotlineContact;
    
    // Preview
    public $emailSubject;
    public $emailBody;
    public $whatsappMessage;

    protected $rules = [
        'selectedCandidates' => 'required|array|min:1',
        'selectedTestTypes' => 'required|array|min:1',
        'testLocation' => 'required|in:online,onsite',
        'scheduledDate' => 'required|date|after:today',
        'scheduledTime' => 'required',
        'expiryDays' => 'required|integer|min:1|max:7',
        'passingGrade' => 'required|integer|min:0|max:100',
        'hotlineContact' => 'required|string',
    ];

    public function mount($job_id)
    {
        $this->job_id = $job_id;
        $this->job = Job::findOrFail($job_id);
        
        // Determine education level from job
        $this->educationLevel = $this->job->education_level;
        
        // Set default hotline
        $this->hotlineContact = '0812-3456-7890';
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

    public function getAvailableTestTypes()
    {
        return PsychotestInvitation::getTestTypesByEducation($this->educationLevel);
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate(['selectedCandidates' => 'required|array|min:1']);
        } elseif ($this->currentStep === 2) {
            $this->validate(['selectedTestTypes' => 'required|array|min:1']);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'testLocation' => 'required',
                'scheduledDate' => 'required|date|after:today',
                'scheduledTime' => 'required',
                'passingGrade' => 'required|integer|min:0|max:100',
                'hotlineContact' => 'required',
            ]);
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
        $testNames = collect($this->selectedTestTypes)->map(function($type) {
            $types = $this->getAvailableTestTypes();
            return $types[$type] ?? $type;
        })->implode(', ');

        $scheduledDateTime = $this->scheduledDate . ' ' . $this->scheduledTime;
        
        // Email template
        $this->emailSubject = "Undangan Psychotest - {$this->job->vacancy_title}";
        $this->emailBody = "Selamat! Anda telah lolos tahap sebelumnya.\n\n";
        $this->emailBody .= "Kami mengundang Anda untuk mengikuti Psychotest:\n";
        $this->emailBody .= "- Jenis Test: {$testNames}\n";
        $this->emailBody .= "- Jadwal: {$scheduledDateTime}\n";
        $this->emailBody .= "- Lokasi: " . ($this->testLocation === 'online' ? 'Online' : 'Onsite') . "\n";
        $this->emailBody .= "- Passing Grade: {$this->passingGrade}%\n\n";
        $this->emailBody .= "Link test akan dikirimkan setelah konfirmasi.\n";
        $this->emailBody .= "Hotline: {$this->hotlineContact}";

        // WhatsApp template
        $this->whatsappMessage = "🎉 Selamat! Anda lolos ke tahap Psychotest.\n";
        $this->whatsappMessage .= "Jadwal: {$scheduledDateTime}\n";
        $this->whatsappMessage .= "Detail lengkap telah dikirim via email.";
    }

    public function sendInvitations()
    {
        $this->validate();

        $scheduledDateTime = $this->scheduledDate . ' ' . $this->scheduledTime;
        $expiresAt = now()->parse($scheduledDateTime)->addDays($this->expiryDays);

        $sentCount = 0;

        foreach ($this->selectedCandidates as $stageId) {
            $stage = ApplicationStage::with('application')->find($stageId);
            
            if (!$stage) continue;

            // Generate unique token
            $token = PsychotestInvitation::generateToken();
            $testLink = url('/psychotest/take/' . $token);

            // Create invitation
            $invitation = PsychotestInvitation::create([
                'application_id' => $stage->application_id,
                'job_id' => $this->job_id,
                'education_level' => $this->educationLevel,
                'test_types' => $this->selectedTestTypes,
                'test_location' => $this->testLocation,
                'scheduled_at' => $scheduledDateTime,
                'expires_at' => $expiresAt,
                'passing_grade' => $this->passingGrade,
                'unique_token' => $token,
                'test_link' => $testLink,
                'guide_pdf_path' => $this->guidePdf ? $this->guidePdf->store('psychotest/guides', 'public') : null,
                'hotline_contact' => $this->hotlineContact,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            // TODO: Send actual email and WhatsApp
            // Mail::to($stage->application->user->email)->send(new PsychotestInvitationMail($invitation));
            
            $sentCount++;
        }

        session()->flash('success', "✅ Berhasil mengirim {$sentCount} undangan psychotest!");
        
        return redirect()->route('hrd.recruitment.stage', [
            'job_id' => $this->job_id,
            'stage' => $this->stage
        ]);
    }

    public function render()
    {
        $candidates = $this->getCandidates();
        $testTypes = $this->getAvailableTestTypes();
        
        return view('livewire.hrd.send-psychotest-invitation', [
            'candidates' => $candidates,
            'testTypes' => $testTypes,
        ]);
    }
}
