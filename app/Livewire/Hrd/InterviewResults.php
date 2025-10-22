<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Interview;
use App\Models\InterviewAssessment;
use App\Models\User;
use Livewire\WithPagination;

class InterviewResults extends Component
{
    use WithPagination;

    // Filters
    public $filterInterviewer;
    public $filterDecision;
    public $filterInterviewType;
    public $filterDateFrom;
    public $filterDateTo;
    public $search = '';
    
    // Modals
    public $showDetailModal = false;
    public $selectedAssessment;
    public $showOverrideModal = false;
    public $overrideDecision;
    public $overrideReason;

    protected $queryString = ['search', 'filterDecision', 'filterInterviewType'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getAssessments()
    {
        $query = InterviewAssessment::with([
            'interview.application.user',
            'interview.application.applicantIdentity',
            'interview.job',
            'interview.interviewer',
            'assessor'
        ])
        ->whereHas('interview', function($q) {
            $q->where('status', 'completed');
        });

        // Search
        if ($this->search) {
            $query->whereHas('interview.application.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterInterviewer) {
            $query->where('assessor_id', $this->filterInterviewer);
        }

        if ($this->filterDecision) {
            $query->where('decision', $this->filterDecision);
        }

        if ($this->filterInterviewType) {
            $query->whereHas('interview', function($q) {
                $q->where('interview_type', $this->filterInterviewType);
            });
        }

        if ($this->filterDateFrom) {
            $query->whereHas('interview', function($q) {
                $q->whereDate('scheduled_at', '>=', $this->filterDateFrom);
            });
        }

        if ($this->filterDateTo) {
            $query->whereHas('interview', function($q) {
                $q->whereDate('scheduled_at', '<=', $this->filterDateTo);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(20);
    }

    public function getStatistics()
    {
        $total = InterviewAssessment::count();
        $passed = InterviewAssessment::where('decision', 'passed')->count();
        $failed = InterviewAssessment::where('decision', 'failed')->count();
        $pending = InterviewAssessment::where('decision', 'pending')->count();
        $avgScore = InterviewAssessment::avg('total_score');

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'pending' => $pending,
            'avg_score' => round($avgScore, 2),
            'pass_rate' => $total > 0 ? round(($passed / $total) * 100, 1) : 0,
        ];
    }

    public function getInterviewers()
    {
        return User::role(['interviewer', 'hr_recruiter', 'admin'])->get();
    }

    public function viewDetail($assessmentId)
    {
        $this->selectedAssessment = InterviewAssessment::with([
            'interview.application.user',
            'interview.application.applicantIdentity',
            'interview.job',
            'assessor',
            'overriddenBy'
        ])->find($assessmentId);
        
        $this->showDetailModal = true;
    }

    public function openOverrideModal($assessmentId)
    {
        $this->selectedAssessment = InterviewAssessment::find($assessmentId);
        $this->overrideDecision = $this->selectedAssessment->decision;
        $this->overrideReason = '';
        $this->showOverrideModal = true;
    }

    public function overrideDecision()
    {
        $this->validate([
            'overrideDecision' => 'required|in:passed,failed',
            'overrideReason' => 'required|min:20',
        ]);

        $this->selectedAssessment->update([
            'decision' => $this->overrideDecision,
            'is_overridden' => true,
            'overridden_by' => auth()->id(),
            'override_reason' => $this->overrideReason,
            'overridden_at' => now(),
        ]);

        // Update application stage if needed
        if ($this->overrideDecision === 'passed') {
            $this->selectedAssessment->interview->application->moveToNextStage();
        }

        session()->flash('success', 'Decision berhasil di-override!');
        
        $this->showOverrideModal = false;
        $this->selectedAssessment = null;
    }

    public function exportResults()
    {
        // TODO: Export to Excel
        session()->flash('info', 'Export functionality coming soon!');
    }

    public function render()
    {
        $assessments = $this->getAssessments();
        $statistics = $this->getStatistics();
        $interviewers = $this->getInterviewers();
        $interviewTypes = Interview::getInterviewTypes();
        
        return view('livewire.hrd.interview-results', [
            'assessments' => $assessments,
            'statistics' => $statistics,
            'interviewers' => $interviewers,
            'interviewTypes' => $interviewTypes,
        ])->layout('layouts.hrd');
    }
}
