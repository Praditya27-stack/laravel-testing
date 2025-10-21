<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $profile_completion = 0;
    public $applications_count = 0;
    public $active_applications = 0;

    public function mount()
    {
        $user = Auth::user();
        
        // Calculate profile completion percentage
        $this->profile_completion = $this->calculateProfileCompletion($user);
        
        // Get applications count
        $this->applications_count = $user->applications()->count();
        $this->active_applications = $user->applications()
            ->whereNotIn('current_stage', ['rejected', 'hired'])
            ->count();
    }

    private function calculateProfileCompletion($user)
    {
        $completion = 0;
        
        // Check if applicant identity exists (14%)
        if ($user->applicantIdentity) {
            $identity = $user->applicantIdentity;
            
            // Section A: Identity (14%)
            if ($identity->full_name && $identity->birth_date && $identity->phone_number) {
                $completion += 14;
            }
        }
        
        // TODO: Add other sections calculation (B-G)
        // For now, return basic completion
        
        return $completion;
    }

    public function render()
    {
        $user = Auth::user();
        
        // Get recent applications
        $recent_applications = $user->applications()
            ->with('job')
            ->latest()
            ->take(5)
            ->get();
        
        return view('livewire.applicant.dashboard', [
            'recent_applications' => $recent_applications,
        ]);
    }
}
