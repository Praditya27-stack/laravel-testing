<?php

use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC ROUTES (Guest)
// ========================================

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Applicant Guidance Page
Route::get('/guide', function () {
    return view('guide');
})->name('guide');

// Job Listings (Public)
Route::get('/jobs', function () {
    return view('jobs.index');
})->name('jobs.index');

// Job Detail (Public)
Route::get('/jobs/{job}', function () {
    return view('jobs.show');
})->name('jobs.show');

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
// APPLICANT ROUTES (Authenticated)
// ========================================

Route::middleware(['auth', 'role:applicant'])->prefix('applicant')->name('applicant.')->group(function () {
    // Applicant Dashboard
    Route::get('/dashboard', function () {
        return view('applicant.dashboard');
    })->name('dashboard');
    
    // Profile Completion (Sections A-G)
    Route::get('/profile/complete', function () {
        return view('applicant.profile.complete');
    })->name('profile.complete');
    
    // My Applications
    Route::get('/applications', function () {
        return view('applicant.applications.index');
    })->name('applications.index');
    
    // Apply for Job
    Route::get('/jobs/{job}/apply', function () {
        return view('applicant.applications.create');
    })->name('applications.create');
});

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
    Route::get('/dashboard', function () {
        return view('hrd.dashboard');
    })->name('dashboard');
    
    // Job Vacancy Management
    Route::get('/jobs', function () {
        return view('hrd.jobs.index');
    })->name('jobs.index');
    
    Route::get('/jobs/create', function () {
        return view('hrd.jobs.create');
    })->name('jobs.create');
    
    Route::get('/jobs/{id}/edit', function ($id) {
        return view('hrd.jobs.edit', ['id' => $id]);
    })->name('jobs.edit');
    
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
    
    // Interview Management
    Route::get('/interview/schedule/{job_id}/{stage}', function ($job_id, $stage) {
        return view('hrd.interview.schedule', ['job_id' => $job_id, 'stage' => $stage]);
    })->name('interview.schedule');
    
    Route::get('/interview/calendar', function () {
        return view('hrd.interview.calendar');
    })->name('interview.calendar');
    
    Route::get('/interview/assess/{interview_id}', function ($interview_id) {
        return view('hrd.interview.assessment', ['interview_id' => $interview_id]);
    })->name('interview.assess');
    
    Route::get('/interview/results', function () {
        return view('hrd.interview.results');
    })->name('interview.results');
});

require __DIR__.'/auth.php';
