<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use App\Models\Application;

class MyApplications extends Component
{
    public $applications;

    public function mount()
    {
        $this->loadApplications();
    }

    public function loadApplications()
    {
        $this->applications = Application::with(['job', 'stages'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.applicant.my-applications')->layout('layouts.landing');
    }
}
