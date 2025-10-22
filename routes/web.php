<?php

use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC ROUTES (Guest)
// ========================================

// Landing Page
Route::get('/', function () {
    // Only redirect HRD/Admin to dashboard, let applicants browse landing page
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasRole(['hrd', 'hr_recruiter', 'admin'])) {
            return redirect()->route('hrd.dashboard');
        }
    }

    return view('landing');
})->name('home');

// Applicant Guidance Page
Route::get('/guide', function () {
    return view('guide');
})->name('guide');

// Job Listings (Public)
Route::get('/jobs', function () {
    $jobs = \App\Models\Job::where('status', 'open')
        ->where(function($query) {
            $query->where('end_date', '>=', now())
                  ->orWhere('closing_at', '>=', now())
                  ->orWhereNull('end_date');
        })
        ->orderBy('created_at', 'desc')
        ->get();
    return view('jobs.index', compact('jobs'));
})->name('jobs.index');

// Job Detail (Public)
Route::get('/jobs/{job}', \App\Livewire\JobDetail::class)->name('jobs.show');

// Background Check Form (Public - for referees)
Route::get('/background-check/{token}', \App\Livewire\BackgroundCheckForm::class)
    ->name('bgc.form');

// ========================================
// AUTHENTICATION ROUTES
// ========================================

// Custom Sign In (using NIK instead of email)
Route::get('/signin', function () {
    return view('auth.signin');
})->name('signin')->middleware('guest');

// Custom Sign Up with NIK verification
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup')->middleware('guest');

// ========================================
// ADMIN ROUTES (HR, Interviewer, Manager)
// ========================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Job Management (HR only)
    Route::middleware('role:hr_recruiter|admin')->group(function () {
        Route::get('/jobs', function () {
            return view('admin.jobs.index');
        })->name('jobs.index');
    });

    // Application Review
    Route::middleware('role:hr_recruiter|interviewer|manager|admin')->group(function () {
        Route::get('/applications', function () {
            return view('admin.applications.index');
        })->name('applications.index');
    });
});

// ========================================
// HRD ROUTES (HR Recruiter)
// ========================================

Route::middleware(['auth', 'role:hr_recruiter|admin'])->prefix('hrd')->name('hrd.')->group(function () {
    // HRD Dashboard
    Route::get('/dashboard', \App\Livewire\Hrd\Dashboard::class)->name('dashboard');

    // Job Vacancy Management
    Route::get('/jobs', \App\Livewire\Hrd\JobsList::class)
        ->name('jobs.index');

    Route::get('/jobs/create', \App\Livewire\Hrd\JobPosting::class)
        ->name('jobs.create');

    Route::get('/jobs/{id}/edit', \App\Livewire\Hrd\JobPosting::class)
        ->name('jobs.edit');

    // Applications Management
    Route::get('/applications', function () {
        return view('hrd.applications.index');
    })->name('applications.index');

    // Recruitment Process
    Route::get('/recruitment/{job_id}', function ($job_id) {
        return view('hrd.recruitment.process', ['job_id' => $job_id]);
    })->name('recruitment.process');

    Route::get('/recruitment/{job_id}/stage/{stage}', function ($job_id, $stage) {
        return view('hrd.recruitment.stage', ['job_id' => $job_id, 'stage' => $stage]);
    })->name('recruitment.stage');

    // Psychotest Management
    Route::get('/psychotest/send/{job_id}', function ($job_id) {
        return view('hrd.psychotest.send-invitation', ['job_id' => $job_id]);
    })->name('psychotest.send');

    Route::get('/psychotest/monitoring', \App\Livewire\Hrd\MonitoringPsychotest::class)
        ->name('psychotest.monitoring');

    Route::get('/psychotest/report', \App\Livewire\Hrd\PsychotestReport::class)
        ->name('psychotest.report');

    Route::get('/psychotest/download', \App\Livewire\Hrd\DownloadPsychotestReport::class)
        ->name('psychotest.download');

    // Interview Management
    Route::get('/interview/schedule/{job_id}/{stage}', function ($job_id, $stage) {
        return view('hrd.interview.schedule', ['job_id' => $job_id, 'stage' => $stage]);
    })->name('interview.schedule');

    Route::get('/interview/calendar', \App\Livewire\Hrd\InterviewCalendar::class)
        ->name('interview.calendar');

    Route::get('/interview/assess/{interview_id}', function ($interview_id) {
        return view('hrd.interview.assessment', ['interview_id' => $interview_id]);
    })->name('interview.assess');

    Route::get('/interview/results', \App\Livewire\Hrd\InterviewResults::class)
        ->name('interview.results');

    // Background Check Management
    Route::get('/background-check/send', \App\Livewire\Hrd\SendBackgroundCheck::class)
        ->name('background-check.send');

    Route::get('/background-check/results', \App\Livewire\Hrd\BackgroundCheckResults::class)
        ->name('background-check.results');

    Route::get('/background-check/followup', \App\Livewire\Hrd\BackgroundCheckFollowup::class)
        ->name('background-check.followup');

    // Medical Checkup Management
    Route::get('/medical-checkup/schedule', \App\Livewire\Hrd\ScheduleMedicalCheckup::class)
        ->name('medical-checkup.schedule');

    Route::get('/medical-checkup/input/{applicationId}', \App\Livewire\Hrd\InputMcuResult::class)
        ->name('medical-checkup.input');

    Route::get('/medical-checkup/status', \App\Livewire\Hrd\MedicalCheckupStatus::class)
        ->name('medical-checkup.status');

    // Hiring Approval & Onboarding
    Route::get('/hiring-approval/request/{applicationId?}', \App\Livewire\Hrd\RequestHiringApproval::class)
        ->name('hiring-approval.request');

    Route::get('/hiring-approval/status', \App\Livewire\Hrd\HiringApprovalStatus::class)
        ->name('hiring-approval.status');

    Route::get('/hiring-approval/offer/{approvalId?}', \App\Livewire\Hrd\GenerateOfferLetter::class)
        ->name('hiring-approval.offer');

    Route::get('/hired-candidates', \App\Livewire\Hrd\HiredCandidates::class)
        ->name('hired-candidates');
});

// ========================================
// APPLICANT ROUTES
// ========================================

Route::middleware(['auth'])->prefix('applicant')->name('applicant.')->group(function () {
    Route::get('/profile', \App\Livewire\Applicant\ProfileCompletion::class)
        ->name('profile');
    
    Route::get('/jobs/{jobId}/apply', \App\Livewire\Applicant\JobApplication::class)
        ->name('job.apply');
    
    Route::get('/application/{id}', \App\Livewire\Applicant\ApplicationTracker::class)
        ->name('application');
    
    Route::get('/my-applications', \App\Livewire\Applicant\MyApplications::class)
        ->name('applications');
});

// Public route for offer acceptance (no auth required, token-based)
Route::get('/offer/{token}', \App\Livewire\Applicant\AcceptOfferLetter::class)
    ->name('offer.accept');

require __DIR__.'/auth.php';
