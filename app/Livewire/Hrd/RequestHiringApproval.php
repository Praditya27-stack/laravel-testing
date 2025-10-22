<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Application;
use App\Models\HiringApprovalRequest;
use App\Models\User;

class RequestHiringApproval extends Component
{
    public $jobId;
    public $applicationId;
    public $application;
    
    // Offer Details
    public $salary_offered;
    public $position_title;
    public $department;
    public $join_date;
    public $briefing_date;
    public $employment_type = 'permanent';
    public $contract_duration_months;
    public $benefits_package;
    public $additional_notes;
    
    // Approval
    public $approver_id;
    
    // Preview
    public $showPreview = false;

    protected $rules = [
        'salary_offered' => 'required|numeric|min:0',
        'position_title' => 'required|string',
        'department' => 'required|string',
        'join_date' => 'required|date|after:today',
        'briefing_date' => 'nullable|date|before:join_date',
        'employment_type' => 'required|in:permanent,contract,internship',
        'contract_duration_months' => 'required_if:employment_type,contract|nullable|integer|min:1',
        'benefits_package' => 'nullable|string',
        'additional_notes' => 'nullable|string',
        'approver_id' => 'required|exists:users,id',
    ];

    public function mount($applicationId = null)
    {
        $this->applicationId = $applicationId;
        
        if ($applicationId) {
            $this->application = Application::with(['user', 'job', 'medicalCheckupResult'])
                ->findOrFail($applicationId);
            
            // Pre-fill from job
            $this->position_title = $this->application->job->vacancy_title ?? $this->application->job->title;
            $this->department = $this->application->job->function ?? $this->application->job->department;
        }
    }

    public function loadCandidates()
    {
        $query = Application::with(['user', 'job'])
            ->where('current_stage', 'hiring_approval')
            ->whereDoesntHave('hiringApprovalRequest');

        if ($this->jobId) {
            $query->where('job_id', $this->jobId);
        }

        return $query->get();
    }

    public function selectCandidate($applicationId)
    {
        $this->applicationId = $applicationId;
        $this->mount($applicationId);
    }

    public function openPreview()
    {
        $this->validate();
        $this->showPreview = true;
    }

    public function submitRequest()
    {
        $this->validate();

        $approvalNumber = HiringApprovalRequest::generateApprovalNumber();

        $approval = HiringApprovalRequest::create([
            'application_id' => $this->applicationId,
            'approval_number' => $approvalNumber,
            'salary_offered' => $this->salary_offered,
            'position_title' => $this->position_title,
            'department' => $this->department,
            'join_date' => $this->join_date,
            'briefing_date' => $this->briefing_date,
            'employment_type' => $this->employment_type,
            'contract_duration_months' => $this->contract_duration_months,
            'benefits_package' => $this->benefits_package,
            'additional_notes' => $this->additional_notes,
            'approver_id' => $this->approver_id,
            'status' => 'pending',
            'requested_by' => auth()->id(),
        ]);

        // TODO: Generate approval document PDF
        // TODO: Send email to approver

        session()->flash('message', "✅ Approval request #{$approvalNumber} sent successfully!");
        
        return redirect()->route('hrd.hiring-approval.status');
    }

    public function getApproversProperty()
    {
        return User::whereHas('roles', function($query) {
            $query->whereIn('name', ['hr_recruiter', 'admin', 'hrd']);
        })->get();
    }

    public function render()
    {
        $candidates = $this->applicationId ? null : $this->loadCandidates();
        
        return view('livewire.hrd.request-hiring-approval', [
            'candidates' => $candidates,
            'approvers' => $this->approvers,
        ])->layout('layouts.hrd');
    }
}
