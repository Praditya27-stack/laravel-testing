<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Test route to check data
Route::get('/test-data', function () {
    return response()->json([
        'employees' => \App\Models\Employee::count(),
        'departments' => \App\Models\Department::count(),
        'attendances' => \App\Models\Attendance::count(),
        'sample_employee' => \App\Models\Employee::with(['department', 'position'])->first(),
    ]);
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Employee Management
Route::resource('employees', EmployeeController::class);

// Attendance Management
Route::resource('attendances', AttendanceController::class);
