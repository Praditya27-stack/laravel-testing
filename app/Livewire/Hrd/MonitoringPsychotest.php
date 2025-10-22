<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\PsychotestInvitation;
use App\Models\PsychotestSession;
use App\Models\Job;
use Livewire\WithPagination;

class MonitoringPsychotest extends Component
{
    use WithPagination;

    // Filters
    public $filterJob;
    public $filterStatus;
    public $filterTestType;
    public $search = '';
    
    // Modals
    public $showDetailModal = false;
    public $selectedInvitation;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getInvitations()
    {
        $query = PsychotestInvitation::with([
            'application.user',
            'application.applicantIdentity',
            'application.job',
            'session'
        ]);

        // Search
        if ($this->search) {
            $query->whereHas('application.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterJob) {
            $query->whereHas('application', function($q) {
                $q->where('job_id', $this->filterJob);
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterTestType) {
            $query->where('test_type', $this->filterTestType);
        }

        return $query->orderBy('test_date', 'desc')->paginate(20);
    }

    public function getStatistics()
    {
        $total = PsychotestInvitation::count();
        $sent = PsychotestInvitation::where('status', 'sent')->count();
        $ongoing = PsychotestInvitation::where('status', 'ongoing')->count();
        $completed = PsychotestInvitation::where('status', 'completed')->count();
        $notAttended = PsychotestInvitation::where('status', 'not_attended')->count();

        return [
            'total' => $total,
            'sent' => $sent,
            'ongoing' => $ongoing,
            'completed' => $completed,
            'not_attended' => $notAttended,
            'attendance_rate' => $total > 0 ? round((($completed + $ongoing) / $total) * 100, 1) : 0,
        ];
    }

    public function getJobs()
    {
        return Job::where('status', 'active')->get();
    }

    public function viewDetail($invitationId)
    {
        $this->selectedInvitation = PsychotestInvitation::with([
            'application.user',
            'application.applicantIdentity',
            'application.job',
            'session.results'
        ])->find($invitationId);
        
        $this->showDetailModal = true;
    }

    public function markAsOngoing($invitationId)
    {
        $invitation = PsychotestInvitation::find($invitationId);
        $invitation->update(['status' => 'ongoing']);

        // Create session if not exists
        if (!$invitation->session) {
            PsychotestSession::create([
                'invitation_id' => $invitation->id,
                'application_id' => $invitation->application_id,
                'started_at' => now(),
                'status' => 'ongoing',
            ]);
        }

        session()->flash('success', 'Status diubah menjadi Ongoing!');
    }

    public function markAsCompleted($invitationId)
    {
        $invitation = PsychotestInvitation::find($invitationId);
        $invitation->update(['status' => 'completed']);

        if ($invitation->session) {
            $invitation->session->update([
                'completed_at' => now(),
                'status' => 'completed',
            ]);
        }

        session()->flash('success', 'Psychotest ditandai selesai!');
    }

    public function markAsNotAttended($invitationId)
    {
        $invitation = PsychotestInvitation::find($invitationId);
        $invitation->update(['status' => 'not_attended']);

        session()->flash('success', 'Ditandai sebagai tidak hadir!');
    }

    public function resendInvitation($invitationId)
    {
        $invitation = PsychotestInvitation::find($invitationId);
        
        // TODO: Resend email and WhatsApp
        
        session()->flash('success', 'Undangan berhasil dikirim ulang!');
    }

    public function render()
    {
        $invitations = $this->getInvitations();
        $statistics = $this->getStatistics();
        $jobs = $this->getJobs();
        
        return view('livewire.hrd.monitoring-psychotest', [
            'invitations' => $invitations,
            'statistics' => $statistics,
            'jobs' => $jobs,
        ])->layout('layouts.hrd');
    }
}
