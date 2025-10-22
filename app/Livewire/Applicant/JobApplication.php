<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use App\Models\Job;
use App\Models\Application;
use App\Models\ApplicantProfile;

class JobApplication extends Component
{
    public $job;
    public $coverLetter = '';
    public $expectedSalary = '';
    public $availableStartDate = '';
    public $profileComplete = false;
    public $completionPercentage = 0;

    public function mount($jobId)
    {
        $this->job = Job::findOrFail($jobId);
        
        // Check profile completion
        $profile = auth()->user()->profile;
        if ($profile) {
            $this->completionPercentage = $profile->calculateCompletionPercentage();
            $this->profileComplete = $profile->isProfileComplete();
        }
        
        // If profile not complete, redirect to profile page
        if (!$this->profileComplete) {
            session()->flash('warning', 'Anda harus melengkapi profil 100% sebelum melamar pekerjaan.');
            return redirect()->route('applicant.profile');
        }
        
        // Check if already applied
        $existingApplication = Application::where('user_id', auth()->id())
            ->where('job_id', $this->job->id)
            ->first();
            
        if ($existingApplication) {
            session()->flash('info', 'Anda sudah melamar posisi ini.');
            return redirect()->route('jobs.show', $this->job->id);
        }
    }

    public function submitApplication()
    {
        $this->validate([
            'coverLetter' => 'required|min:100',
            'expectedSalary' => 'nullable|numeric|min:0',
            'availableStartDate' => 'required|date|after:today',
        ]);

        // Generate application number
        $applicationNumber = 'APP-' . date('Ymd') . '-' . str_pad(Application::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Create application
        $application = Application::create([
            'application_number' => $applicationNumber,
            'user_id' => auth()->id(),
            'job_id' => $this->job->id,
            'cover_letter' => $this->coverLetter,
            'expected_salary' => $this->expectedSalary,
            'available_start_date' => $this->availableStartDate,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        // Create initial stage (Application Review)
        $application->stages()->create([
            'stage_name' => 'Application Review',
            'stage_order' => 1,
            'status' => 'pending',
            'started_at' => now(),
        ]);

        session()->flash('success', '🎉 Lamaran berhasil dikirim! Kami akan menghubungi Anda jika lolos seleksi administrasi.');
        
        return redirect()->route('applicant.applications');
    }

    public function render()
    {
        return view('livewire.applicant.job-application')->layout('layouts.landing');
    }
}
