<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Job;
use App\Models\Application;
use App\Models\ApplicationStage;
use App\Models\ApplicantIdentity;
use Illuminate\Support\Facades\Auth;

class AdministrativeSelection extends Component
{
    use WithPagination;

    public $job_id;
    public $stage;
    public $job;

    // Sort & Filter
    public $sortBy = 'newest';
    public $filterAge = [18, 60];
    public $filterEducation = [];
    public $filterMajor = [];
    public $filterSchool = '';
    public $filterGPA = [0, 4];
    public $filterWorkExp = '';
    public $search = '';

    // Bulk Selection
    public $selectedCandidates = [];
    public $selectAll = false;

    // Modals
    public $showFilterModal = false;
    public $viewingCandidate = null;
    public $reviewingCandidate = null;
    public $bulkActionModal = null;

    // Review Form
    public $reviewNotes = '';
    public $rejectionReason = '';
    public $requestedDocuments = [];

    protected $queryString = ['sortBy', 'search'];

    public function mount($job_id, $stage)
    {
        $this->job_id = $job_id;
        $this->stage = $stage;
        $this->job = Job::findOrFail($job_id);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCandidates = $this->getCandidates()->pluck('id')->toArray();
        } else {
            $this->selectedCandidates = [];
        }
    }

    public function toggleCandidate($candidateId)
    {
        if (in_array($candidateId, $this->selectedCandidates)) {
            $this->selectedCandidates = array_diff($this->selectedCandidates, [$candidateId]);
        } else {
            $this->selectedCandidates[] = $candidateId;
        }
    }

    public function getCandidates()
    {
        $query = ApplicationStage::with(['application.user', 'application.applicantIdentity'])
            ->where('stage_name', $this->stage)
            ->whereHas('application', function($q) {
                $q->where('job_id', $this->job_id);
            })
            ->where('status', 'in_progress');

        // Search
        if ($this->search) {
            $query->whereHas('application.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Sort
        switch ($this->sortBy) {
            case 'name_asc':
                $query->join('applications', 'application_stages.application_id', '=', 'applications.id')
                      ->join('users', 'applications.user_id', '=', 'users.id')
                      ->orderBy('users.name', 'asc')
                      ->select('application_stages.*');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
        }

        return $query->get();
    }

    public function viewCandidate($stageId)
    {
        $this->viewingCandidate = ApplicationStage::with(['application.user', 'application.applicantIdentity'])
            ->findOrFail($stageId);
    }

    public function closeViewModal()
    {
        $this->viewingCandidate = null;
    }

    public function startReview($stageId)
    {
        $this->reviewingCandidate = ApplicationStage::with(['application.user', 'application.applicantIdentity'])
            ->findOrFail($stageId);
        $this->reviewNotes = '';
        $this->rejectionReason = '';
    }

    public function markAsPassed()
    {
        if (!$this->reviewingCandidate) return;

        $this->reviewingCandidate->markAsPassed(Auth::id(), $this->reviewNotes);
        
        // Move to next stage
        $this->reviewingCandidate->application->moveToNextStage();

        session()->flash('success', 'Candidate marked as passed and moved to next stage!');
        
        $this->reviewingCandidate = null;
        $this->reviewNotes = '';
    }

    public function markAsFailed()
    {
        if (!$this->reviewingCandidate || !$this->rejectionReason) {
            session()->flash('error', 'Please select a rejection reason.');
            return;
        }

        $this->reviewingCandidate->markAsFailed(Auth::id(), $this->rejectionReason, $this->reviewNotes);
        
        session()->flash('success', 'Candidate marked as failed.');
        
        $this->reviewingCandidate = null;
        $this->reviewNotes = '';
        $this->rejectionReason = '';
    }

    public function bulkPass()
    {
        if (empty($this->selectedCandidates)) {
            session()->flash('error', 'No candidates selected.');
            return;
        }

        $stages = ApplicationStage::whereIn('id', $this->selectedCandidates)->get();
        
        foreach ($stages as $stage) {
            $stage->markAsPassed(Auth::id(), 'Bulk approval');
            $stage->application->moveToNextStage();
        }

        session()->flash('success', count($this->selectedCandidates) . ' candidates passed and moved to next stage!');
        
        $this->selectedCandidates = [];
        $this->selectAll = false;
        $this->bulkActionModal = null;
    }

    public function bulkReject()
    {
        if (empty($this->selectedCandidates) || !$this->rejectionReason) {
            session()->flash('error', 'Please select candidates and rejection reason.');
            return;
        }

        $stages = ApplicationStage::whereIn('id', $this->selectedCandidates)->get();
        
        foreach ($stages as $stage) {
            $stage->markAsFailed(Auth::id(), $this->rejectionReason, 'Bulk rejection');
        }

        session()->flash('success', count($this->selectedCandidates) . ' candidates rejected.');
        
        $this->selectedCandidates = [];
        $this->selectAll = false;
        $this->bulkActionModal = null;
        $this->rejectionReason = '';
    }

    public function render()
    {
        $candidates = $this->getCandidates();
        
        return view('livewire.hrd.administrative-selection', [
            'candidates' => $candidates,
        ]);
    }
}
