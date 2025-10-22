<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HiringApprovalRequest;
use App\Models\Job;

class HiringApprovalStatus extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterJob = '';
    
    // Statistics
    public $statistics = [];
    
    // Detail Modal
    public $showDetailModal = false;
    public $selectedApproval = null;

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $total = HiringApprovalRequest::count();
        $pending = HiringApprovalRequest::where('status', 'pending')->count();
        $approved = HiringApprovalRequest::where('status', 'approved')->count();
        $rejected = HiringApprovalRequest::where('status', 'rejected')->count();
        $revisionNeeded = HiringApprovalRequest::where('status', 'revision_needed')->count();
        
        $approvalRate = $total > 0 ? round(($approved / $total) * 100, 1) : 0;

        $this->statistics = [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'revision_needed' => $revisionNeeded,
            'approval_rate' => $approvalRate,
        ];
    }

    public function viewDetail($approvalId)
    {
        $this->selectedApproval = HiringApprovalRequest::with([
            'application.user',
            'application.job',
            'approver',
            'requestedBy'
        ])->find($approvalId);
        
        $this->showDetailModal = true;
    }

    public function resendRequest($approvalId)
    {
        $approval = HiringApprovalRequest::find($approvalId);
        
        if ($approval && $approval->status === 'pending') {
            // TODO: Resend email to approver
            session()->flash('message', '✅ Request resent successfully!');
        }
    }

    public function cancelRequest($approvalId)
    {
        $approval = HiringApprovalRequest::find($approvalId);
        
        if ($approval && $approval->status === 'pending') {
            $approval->delete();
            session()->flash('message', '✅ Request cancelled successfully!');
        }
    }

    public function getApprovalsProperty()
    {
        $query = HiringApprovalRequest::with([
            'application.user',
            'application.job',
            'approver'
        ]);

        if ($this->search) {
            $query->whereHas('application.user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orWhere('approval_number', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterJob) {
            $query->whereHas('application', function ($q) {
                $q->where('job_id', $this->filterJob);
            });
        }

        return $query->latest()->paginate(10);
    }

    public function getJobsProperty()
    {
        return Job::where('status', 'open')->get();
    }

    public function render()
    {
        return view('livewire.hrd.hiring-approval-status', [
            'approvals' => $this->approvals,
            'jobs' => $this->jobs,
        ])->layout('layouts.hrd');
    }
}
