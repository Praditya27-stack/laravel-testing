<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Application;
use App\Models\Job;

class Dashboard extends Component
{
    use WithPagination;

    public $stats = [];
    public $filterStatus = 'all';
    public $filterJob = 'all';
    public $search = '';

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_applications' => Application::count(),
            'new_applications' => Application::where('status', 'submitted')->count(),
            'in_progress' => Application::whereIn('status', ['screening', 'interview', 'assessment'])->count(),
            'hired' => Application::where('status', 'hired')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
            'active_jobs' => Job::where('status', 'open')->count(),
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterJob()
    {
        $this->resetPage();
    }

    public function render()
    {
        $applications = Application::with(['user.profile', 'job'])
            ->when($this->search, function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('application_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus !== 'all', function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterJob !== 'all', function($query) {
                $query->where('job_id', $this->filterJob);
            })
            ->latest()
            ->paginate(20);

        $jobs = Job::where('status', 'open')->get();

        return view('livewire.hrd.dashboard', [
            'applications' => $applications,
            'jobs' => $jobs,
        ])->layout('layouts.hrd');
    }
}
