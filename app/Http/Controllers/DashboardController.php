<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Leave;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::where('status', 'active')->count();
        $totalDepartments = Department::where('is_active', true)->count();
        
        // Today's attendance (or latest if no data today)
        $todayAttendance = Attendance::whereDate('date', Carbon::today())->count();
        if ($todayAttendance == 0) {
            // If no attendance today, count latest date
            $latestDate = Attendance::latest('date')->first()?->date;
            if ($latestDate) {
                $todayAttendance = Attendance::whereDate('date', $latestDate)->count();
            }
        }
        
        // Pending leaves
        $pendingLeaves = Leave::where('status', 'pending')->count();
        
        // Recent employees
        $recentEmployees = Employee::with(['department', 'position'])
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();
        
        // Recent attendances (show latest regardless of date)
        $recentAttendances = Attendance::with('employee')
            ->latest('date')
            ->latest('created_at')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'todayAttendance',
            'pendingLeaves',
            'recentEmployees',
            'recentAttendances'
        ));
    }
}
