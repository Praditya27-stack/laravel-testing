<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Job;

class JobsList extends Component
{
    use WithPagination;

    public $search = '';
    public $status_filter = '';
    public $position_filter = '';
    public $education_filter = '';
    
    public $deleteId = null;
    public $closeId = null;

    protected $queryString = ['search', 'status_filter', 'position_filter', 'education_filter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteJob()
    {
        if ($this->deleteId) {
            Job::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Job vacancy deleted successfully!');
            $this->deleteId = null;
        }
    }

    public function confirmClose($id)
    {
        $this->closeId = $id;
    }

    public function closeJob()
    {
        if ($this->closeId) {
            $job = Job::findOrFail($this->closeId);
            $job->update(['status' => 'closed']);
            session()->flash('success', 'Job vacancy closed successfully!');
            $this->closeId = null;
        }
    }

    public function duplicateJob($id)
    {
        $job = Job::findOrFail($id);
        $newJob = $job->replicate();
        $newJob->code = $this->generateJobCode();
        $newJob->status = 'draft';
        $newJob->save();
        
        session()->flash('success', 'Job duplicated successfully!');
        return redirect()->route('hrd.jobs.edit', $newJob->id);
    }

    private function generateJobCode()
    {
        $prefix = 'JOB';
        $year = date('Y');
        $month = date('m');
        
        $lastJob = Job::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastJob ? (int)substr($lastJob->code, -4) + 1 : 1;
        
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    public function render()
    {
        $jobs = Job::query()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('vacancy_title', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status_filter, function($query) {
                $query->where('status', $this->status_filter);
            })
            ->when($this->position_filter, function($query) {
                $query->where('position', $this->position_filter);
            })
            ->when($this->education_filter, function($query) {
                $query->where('education_level', $this->education_filter);
            })
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.hrd.jobs-list', [
            'jobs' => $jobs,
        ])->layout('layouts.hrd');
    }
}
