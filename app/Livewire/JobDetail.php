<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;
use App\Models\Application;

class JobDetail extends Component
{
    public $job;
    public $hasApplied = false;
    public $canApply = false;

    public function mount($job)
    {
        $this->job = Job::findOrFail($job);
        
        // Check if user is logged in and has applied
        if (auth()->check()) {
            $this->hasApplied = Application::where('user_id', auth()->id())
                ->where('job_id', $this->job->id)
                ->exists();
                
            // Check if profile is complete
            $profile = auth()->user()->profile;
            $this->canApply = $profile && $profile->isProfileComplete();
        }
    }

    public function render()
    {
        return view('livewire.job-detail')->layout('layouts.landing');
    }
}
