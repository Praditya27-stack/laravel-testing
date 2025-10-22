<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Application;
use App\Models\ApplicationReferee;
use App\Models\BackgroundCheckRequest;
use App\Models\BackgroundCheckFollowup;
use Illuminate\Support\Str;

class SendBackgroundCheck extends Component
{
    public $jobId;
    public $currentStep = 1;
    
    // Step 1: Select Candidates
    public $candidates = [];
    public $selectedCandidates = [];
    public $selectAll = false;
    
    // Step 2: Select Referees
    public $candidateReferees = [];
    public $selectedReferees = [];
    
    // Step 3: Configure & Send
    public $expiryDays = 7;
    public $sendMethod = 'both';
    public $customMessage = '';
    
    // Preview
    public $showPreview = false;
    public $previewData = [];

    protected $rules = [
        'selectedCandidates' => 'required|array|min:1',
        'selectedReferees' => 'required|array|min:1',
        'expiryDays' => 'required|integer|min:1|max:30',
        'sendMethod' => 'required|in:email,whatsapp,both',
    ];

    public function mount($jobId = null)
    {
        $this->jobId = $jobId;
        $this->loadCandidates();
    }

    public function loadCandidates()
    {
        $query = Application::with(['user', 'job', 'referees'])
            ->where('current_stage', 'background_check');

        if ($this->jobId) {
            $query->where('job_id', $this->jobId);
        }

        $this->candidates = $query->get();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCandidates = $this->candidates->pluck('id')->toArray();
        } else {
            $this->selectedCandidates = [];
        }
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate(['selectedCandidates' => 'required|array|min:1']);
            $this->loadReferees();
            $this->currentStep = 2;
        } elseif ($this->currentStep === 2) {
            $this->validate(['selectedReferees' => 'required|array|min:1']);
            $this->currentStep = 3;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function loadReferees()
    {
        $this->candidateReferees = Application::with(['user', 'referees'])
            ->whereIn('id', $this->selectedCandidates)
            ->get()
            ->map(function ($application) {
                return [
                    'application' => $application,
                    'referees' => $application->referees,
                ];
            });
    }

    public function toggleReferee($refereeId)
    {
        if (in_array($refereeId, $this->selectedReferees)) {
            $this->selectedReferees = array_diff($this->selectedReferees, [$refereeId]);
        } else {
            $this->selectedReferees[] = $refereeId;
        }
    }

    public function openPreview()
    {
        $this->validate();
        
        $this->previewData = ApplicationReferee::with(['application.user', 'application.job'])
            ->whereIn('id', $this->selectedReferees)
            ->get();
        
        $this->showPreview = true;
    }

    public function sendForms()
    {
        $this->validate();

        $successCount = 0;
        $failCount = 0;

        foreach ($this->selectedReferees as $refereeId) {
            try {
                $referee = ApplicationReferee::with('application')->find($refereeId);
                
                if (!$referee) {
                    $failCount++;
                    continue;
                }

                // Create BGC Request
                $request = BackgroundCheckRequest::create([
                    'application_id' => $referee->application_id,
                    'referee_id' => $referee->id,
                    'token' => Str::random(64),
                    'link_expiry_date' => now()->addDays($this->expiryDays),
                    'status' => 'sent',
                    'send_method' => $this->sendMethod,
                    'sent_at' => now(),
                    'sent_by' => auth()->id(),
                ]);

                // Generate form link
                $request->form_link = route('bgc.form', ['token' => $request->token]);
                $request->save();

                // Log followup
                BackgroundCheckFollowup::create([
                    'request_id' => $request->id,
                    'action_type' => $this->sendMethod === 'both' ? 'email_sent' : ($this->sendMethod . '_sent'),
                    'notes' => 'Initial BGC form sent',
                    'performed_by' => auth()->id(),
                ]);

                // TODO: Send actual email/WhatsApp
                // For now, just mark as sent

                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                \Log::error('BGC Send Error: ' . $e->getMessage());
            }
        }

        session()->flash('message', "✅ Background check forms sent! Success: {$successCount}, Failed: {$failCount}");
        
        return redirect()->route('hrd.background-check.results');
    }

    public function getDefaultMessage()
    {
        return "Dear [Referee Name],

We are conducting a background check for [Candidate Name] who has applied for a position at PT Aisin Indonesia.

As a reference provided by the candidate, we would appreciate if you could complete a brief questionnaire about their work performance and character.

Please click the link below to access the form:
[Form Link]

This link will expire in {$this->expiryDays} days.

Thank you for your cooperation.

Best regards,
HR Department
PT Aisin Indonesia";
    }

    public function render()
    {
        return view('livewire.hrd.send-background-check')->layout('layouts.hrd');
    }
}
