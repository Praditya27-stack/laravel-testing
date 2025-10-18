<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Protected Routes - Require Authentication
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Attendance Management
    Route::resource('attendances', AttendanceController::class);
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test route to check data (remove in production)
Route::get('/test-data', function () {
    return response()->json([
        'employees' => \App\Models\Employee::count(),
        'departments' => \App\Models\Department::count(),
        'attendances' => \App\Models\Attendance::count(),
        'sample_employee' => \App\Models\Employee::with(['department', 'position'])->first(),
    ]);
});

require __DIR__.'/auth.php';
