<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\PsychotestResult;
use App\Models\PsychotestSession;
use App\Models\Job;
use Livewire\WithPagination;

class PsychotestReport extends Component
{
    use WithPagination;

    // Filters
    public $filterJob;
    public $filterResult;
    public $filterTestType;
    public $search = '';
    
    // Modals
    public $showDetailModal = false;
    public $selectedResult;
    public $showScoreModal = false;
    public $selectedSession;
    
    // Scoring
    public $scores = [];
    public $totalScore;
    public $result = 'pending';
    public $notes;

    protected $queryString = ['search', 'filterResult'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getResults()
    {
        $query = PsychotestResult::with([
            'session.invitation.application.user',
            'session.invitation.application.applicantIdentity',
            'session.invitation.application.job'
        ]);

        // Search
        if ($this->search) {
            $query->whereHas('session.invitation.application.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterJob) {
            $query->whereHas('session.invitation.application', function($q) {
                $q->where('job_id', $this->filterJob);
            });
        }

        if ($this->filterResult) {
            $query->where('result', $this->filterResult);
        }

        if ($this->filterTestType) {
            $query->where('test_type', $this->filterTestType);
        }

        return $query->orderBy('created_at', 'desc')->paginate(20);
    }

    public function getStatistics()
    {
        $total = PsychotestResult::count();
        $passed = PsychotestResult::where('result', 'passed')->count();
        $failed = PsychotestResult::where('result', 'failed')->count();
        $pending = PsychotestResult::where('result', 'pending')->count();
        $avgScore = PsychotestResult::avg('total_score');

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'pending' => $pending,
            'avg_score' => round($avgScore, 2),
            'pass_rate' => $total > 0 ? round(($passed / $total) * 100, 1) : 0,
        ];
    }

    public function getJobs()
    {
        return Job::where('status', 'active')->get();
    }

    public function viewDetail($resultId)
    {
        $this->selectedResult = PsychotestResult::with([
            'session.invitation.application.user',
            'session.invitation.application.applicantIdentity',
            'session.invitation.application.job'
        ])->find($resultId);
        
        $this->showDetailModal = true;
    }

    public function openScoreModal($sessionId)
    {
        $this->selectedSession = PsychotestSession::with([
            'invitation.application.user',
            'results'
        ])->find($sessionId);
        
        // Initialize scores from existing results
        $this->scores = [];
        foreach ($this->selectedSession->results as $result) {
            $this->scores[$result->test_type] = $result->score;
        }
        
        $this->calculateTotalScore();
        $this->showScoreModal = true;
    }

    public function calculateTotalScore()
    {
        if (empty($this->scores)) {
            $this->totalScore = 0;
            return;
        }

        $this->totalScore = round(array_sum($this->scores) / count($this->scores), 2);
        
        // Auto determine result based on passing grade
        $passingGrade = $this->selectedSession->invitation->passing_grade ?? 70;
        $this->result = $this->totalScore >= $passingGrade ? 'passed' : 'failed';
    }

    public function saveScores()
    {
        $this->validate([
            'scores' => 'required|array',
            'result' => 'required|in:passed,failed,pending',
        ]);

        $this->calculateTotalScore();

        foreach ($this->scores as $testType => $score) {
            PsychotestResult::updateOrCreate(
                [
                    'session_id' => $this->selectedSession->id,
                    'test_type' => $testType,
                ],
                [
                    'application_id' => $this->selectedSession->application_id,
                    'score' => $score,
                    'total_score' => $this->totalScore,
                    'result' => $this->result,
                    'notes' => $this->notes,
                    'evaluated_at' => now(),
                ]
            );
        }

        // Update session
        $this->selectedSession->update([
            'total_score' => $this->totalScore,
            'result' => $this->result,
        ]);

        // Update invitation
        $this->selectedSession->invitation->update([
            'status' => 'completed',
        ]);

        // If passed, move to next stage
        if ($this->result === 'passed') {
            $this->selectedSession->invitation->application->moveToNextStage();
        }

        session()->flash('success', '✅ Scoring berhasil disimpan!');
        
        $this->showScoreModal = false;
        $this->selectedSession = null;
    }

    public function render()
    {
        $results = $this->getResults();
        $statistics = $this->getStatistics();
        $jobs = $this->getJobs();
        
        return view('livewire.hrd.psychotest-report', [
            'results' => $results,
            'statistics' => $statistics,
            'jobs' => $jobs,
        ])->layout('layouts.hrd');
    }
}
