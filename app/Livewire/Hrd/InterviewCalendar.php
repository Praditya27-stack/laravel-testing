<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InterviewCalendar extends Component
{
    // Filters
    public $filterInterviewer;
    public $filterDateFrom;
    public $filterDateTo;
    public $filterType;
    public $filterStatus;
    
    // Actions
    public $selectedInterview;
    public $showRescheduleModal = false;
    public $showCancelModal = false;
    public $cancellationReason;
    
    // Reschedule fields
    public $newScheduledDate;
    public $newScheduledTime;

    public function mount()
    {
        // Set default date range (current month)
        $this->filterDateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->filterDateTo = now()->endOfMonth()->format('Y-m-d');
    }

    public function getInterviews()
    {
        $query = Interview::with(['application.user', 'interviewer', 'job'])
            ->orderBy('scheduled_at', 'asc');

        // Apply filters
        if ($this->filterInterviewer) {
            $query->where('interviewer_id', $this->filterInterviewer);
        }

        if ($this->filterDateFrom) {
            $query->whereDate('scheduled_at', '>=', $this->filterDateFrom);
        }

        if ($this->filterDateTo) {
            $query->whereDate('scheduled_at', '<=', $this->filterDateTo);
        }

        if ($this->filterType) {
            $query->where('interview_type', $this->filterType);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return $query->get();
    }

    public function getInterviewers()
    {
        return User::role(['interviewer', 'hr_recruiter', 'admin'])->get();
    }

    public function openRescheduleModal($interviewId)
    {
        $this->selectedInterview = Interview::find($interviewId);
        $this->newScheduledDate = $this->selectedInterview->scheduled_at->format('Y-m-d');
        $this->newScheduledTime = $this->selectedInterview->scheduled_at->format('H:i');
        $this->showRescheduleModal = true;
    }

    public function rescheduleInterview()
    {
        $this->validate([
            'newScheduledDate' => 'required|date|after:today',
            'newScheduledTime' => 'required',
        ]);

        $newDateTime = $this->newScheduledDate . ' ' . $this->newScheduledTime;

        $this->selectedInterview->update([
            'scheduled_at' => $newDateTime,
        ]);

        // TODO: Send reschedule notification

        session()->flash('success', 'Interview berhasil dijadwalkan ulang!');
        
        $this->showRescheduleModal = false;
        $this->selectedInterview = null;
    }

    public function openCancelModal($interviewId)
    {
        $this->selectedInterview = Interview::find($interviewId);
        $this->cancellationReason = '';
        $this->showCancelModal = true;
    }

    public function cancelInterview()
    {
        $this->validate([
            'cancellationReason' => 'required|min:10',
        ]);

        $this->selectedInterview->cancel($this->cancellationReason);

        // TODO: Send cancellation notification

        session()->flash('success', 'Interview berhasil dibatalkan!');
        
        $this->showCancelModal = false;
        $this->selectedInterview = null;
    }

    public function markAsCompleted($interviewId)
    {
        $interview = Interview::find($interviewId);
        $interview->markAsCompleted();

        session()->flash('success', 'Interview ditandai sebagai selesai!');
    }

    public function sendReminder($interviewId)
    {
        $interview = Interview::find($interviewId);
        
        // TODO: Send reminder email/WhatsApp
        
        $interview->update(['reminder_sent_at' => now()]);

        session()->flash('success', 'Reminder berhasil dikirim!');
    }

    public function render()
    {
        $interviews = $this->getInterviews();
        $interviewers = $this->getInterviewers();
        $interviewTypes = Interview::getInterviewTypes();
        
        return view('livewire.hrd.interview-calendar', [
            'interviews' => $interviews,
            'interviewers' => $interviewers,
            'interviewTypes' => $interviewTypes,
        ])->layout('layouts.hrd');
    }
}
