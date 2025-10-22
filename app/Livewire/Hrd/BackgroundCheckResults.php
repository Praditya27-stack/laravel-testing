<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BackgroundCheckRequest;
use App\Models\BackgroundCheckResponse;
use App\Models\BackgroundCheckResult;
use App\Models\Job;

class BackgroundCheckResults extends Component
{
    use WithPagination;

    public $search = '';
    public $filterJob = '';
    public $filterStatus = '';
    public $filterResult = '';
    
    // Statistics
    public $statistics = [];
    
    // Detail Modal
    public $showDetailModal = false;
    public $selectedResponse = null;
    
    // Assessment Modal
    public $showAssessmentModal = false;
    public $assessmentResult = 'passed';
    public $assessmentNotes = '';
    public $additionalInfo = '';

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $total = BackgroundCheckRequest::count();
        $sent = BackgroundCheckRequest::where('status', 'sent')->count();
        $completed = BackgroundCheckRequest::where('status', 'completed')->count();
        $pending = BackgroundCheckRequest::where('status', 'pending')->count();
        $expired = BackgroundCheckRequest::where('status', 'expired')->count();
        
        $passed = BackgroundCheckResult::where('result', 'passed')->count();
        $failed = BackgroundCheckResult::where('result', 'failed')->count();
        $needReview = BackgroundCheckResult::where('result', 'need_more_info')->count();
        
        $avgRating = BackgroundCheckResponse::avg('average_rating') ?? 0;
        $responseRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

        $this->statistics = [
            'total' => $total,
            'sent' => $sent,
            'completed' => $completed,
            'pending' => $pending,
            'expired' => $expired,
            'passed' => $passed,
            'failed' => $failed,
            'need_review' => $needReview,
            'avg_rating' => round($avgRating, 2),
            'response_rate' => $responseRate,
        ];
    }

    public function viewDetail($responseId)
    {
        $this->selectedResponse = BackgroundCheckResponse::with([
            'request.referee',
            'request.application.user',
            'request.application.job',
            'result'
        ])->find($responseId);
        
        $this->showDetailModal = true;
    }

    public function openAssessment($responseId)
    {
        $this->selectedResponse = BackgroundCheckResponse::with([
            'request.application',
            'result'
        ])->find($responseId);
        
        if ($this->selectedResponse->result) {
            $this->assessmentResult = $this->selectedResponse->result->result;
            $this->assessmentNotes = $this->selectedResponse->result->hr_notes;
            $this->additionalInfo = $this->selectedResponse->result->additional_info;
        } else {
            // Get system suggestion
            $suggestion = $this->selectedResponse->getSystemSuggestion();
            $this->assessmentResult = $suggestion['suggestion'] === 'pass' ? 'passed' : ($suggestion['suggestion'] === 'fail' ? 'failed' : 'pending');
        }
        
        $this->showAssessmentModal = true;
    }

    public function saveAssessment()
    {
        $this->validate([
            'assessmentResult' => 'required|in:passed,failed,pending,need_more_info',
            'assessmentNotes' => 'nullable|string',
        ]);

        $suggestion = $this->selectedResponse->getSystemSuggestion();

        $result = BackgroundCheckResult::updateOrCreate(
            [
                'application_id' => $this->selectedResponse->application_id,
                'response_id' => $this->selectedResponse->id,
            ],
            [
                'result' => $this->assessmentResult,
                'hr_notes' => $this->assessmentNotes,
                'additional_info' => $this->additionalInfo,
                'system_suggestion' => $suggestion['suggestion'],
                'suggestion_reason' => $suggestion['reason'],
                'assessed_by' => auth()->id(),
                'assessed_at' => now(),
            ]
        );

        // Update application stage if passed or failed
        if ($this->assessmentResult === 'passed') {
            $result->markAsPassed($this->assessmentNotes, auth()->id());
            session()->flash('message', '✅ Candidate passed background check and moved to Medical Checkup stage!');
        } elseif ($this->assessmentResult === 'failed') {
            $result->markAsFailed($this->assessmentNotes, auth()->id());
            session()->flash('message', '❌ Candidate failed background check. Application rejected.');
        } else {
            session()->flash('message', '✅ Assessment saved successfully!');
        }

        $this->showAssessmentModal = false;
        $this->loadStatistics();
        $this->reset(['selectedResponse', 'assessmentResult', 'assessmentNotes', 'additionalInfo']);
    }

    public function getResponsesProperty()
    {
        $query = BackgroundCheckResponse::with([
            'request.referee',
            'request.application.user',
            'request.application.job',
            'result'
        ]);

        if ($this->search) {
            $query->whereHas('request.application.user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterJob) {
            $query->whereHas('request.application', function ($q) {
                $q->where('job_id', $this->filterJob);
            });
        }

        if ($this->filterResult) {
            $query->whereHas('result', function ($q) {
                $q->where('result', $this->filterResult);
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
        return view('livewire.hrd.background-check-results', [
            'responses' => $this->responses,
            'jobs' => $this->jobs,
        ])->layout('layouts.hrd');
    }
}
