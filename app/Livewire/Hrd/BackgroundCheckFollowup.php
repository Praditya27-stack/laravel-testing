<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BackgroundCheckRequest;
use App\Models\BackgroundCheckFollowup as FollowupModel;
use App\Models\Job;

class BackgroundCheckFollowup extends Component
{
    use WithPagination;

    public $search = '';
    public $filterJob = '';
    public $filterDays = '';
    
    // Extend Expiry Modal
    public $showExtendModal = false;
    public $selectedRequest = null;
    public $extendDays = 7;
    
    // Phone Call Modal
    public $showPhoneCallModal = false;
    public $phoneCallNotes = '';

    public function sendReminder($requestId)
    {
        $request = BackgroundCheckRequest::find($requestId);
        
        if (!$request) {
            session()->flash('error', 'Request not found');
            return;
        }

        $request->sendReminder();
        
        // Log followup
        FollowupModel::create([
            'request_id' => $request->id,
            'action_type' => 'reminder_sent',
            'notes' => 'Reminder sent via ' . $request->send_method,
            'performed_by' => auth()->id(),
        ]);

        // TODO: Send actual reminder email/WhatsApp

        session()->flash('message', '✅ Reminder sent successfully!');
    }

    public function openExtendModal($requestId)
    {
        $this->selectedRequest = BackgroundCheckRequest::with(['referee', 'application.user'])->find($requestId);
        $this->showExtendModal = true;
    }

    public function extendExpiry()
    {
        $this->validate([
            'extendDays' => 'required|integer|min:1|max:30',
        ]);

        $this->selectedRequest->extendExpiry($this->extendDays);
        
        // Log followup
        FollowupModel::create([
            'request_id' => $this->selectedRequest->id,
            'action_type' => 'expiry_extended',
            'notes' => "Expiry extended by {$this->extendDays} days",
            'performed_by' => auth()->id(),
        ]);

        // TODO: Send extension notice email

        session()->flash('message', "✅ Link expiry extended by {$this->extendDays} days!");
        
        $this->showExtendModal = false;
        $this->reset(['selectedRequest', 'extendDays']);
    }

    public function openPhoneCallModal($requestId)
    {
        $this->selectedRequest = BackgroundCheckRequest::with(['referee', 'application.user'])->find($requestId);
        $this->showPhoneCallModal = true;
    }

    public function logPhoneCall()
    {
        $this->validate([
            'phoneCallNotes' => 'required|string|min:10',
        ]);

        FollowupModel::create([
            'request_id' => $this->selectedRequest->id,
            'action_type' => 'phone_call',
            'notes' => $this->phoneCallNotes,
            'performed_by' => auth()->id(),
        ]);

        session()->flash('message', '✅ Phone call logged successfully!');
        
        $this->showPhoneCallModal = false;
        $this->reset(['selectedRequest', 'phoneCallNotes']);
    }

    public function getPendingRequestsProperty()
    {
        $query = BackgroundCheckRequest::with([
            'referee',
            'application.user',
            'application.job',
            'followups'
        ])->whereIn('status', ['sent', 'pending']);

        if ($this->search) {
            $query->whereHas('application.user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orWhereHas('referee', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterJob) {
            $query->whereHas('application', function ($q) {
                $q->where('job_id', $this->filterJob);
            });
        }

        if ($this->filterDays === 'sent_3_days') {
            $query->where('sent_at', '<=', now()->subDays(3));
        } elseif ($this->filterDays === 'expiring_2_days') {
            $query->where('link_expiry_date', '<=', now()->addDays(2))
                  ->where('link_expiry_date', '>=', now());
        } elseif ($this->filterDays === 'reminded_3_times') {
            $query->where('reminder_count', '>=', 3);
        }

        return $query->latest('sent_at')->paginate(10);
    }

    public function getJobsProperty()
    {
        return Job::where('status', 'open')->get();
    }

    public function render()
    {
        return view('livewire.hrd.background-check-followup', [
            'pendingRequests' => $this->pendingRequests,
            'jobs' => $this->jobs,
        ])->layout('layouts.hrd');
    }
}
