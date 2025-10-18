<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'position'])
            ->latest()
            ->paginate(10);
        
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        
        return view('employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number' => 'required|unique:employees',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'id_card_number' => 'nullable|string|max:255|unique:employees',
            'tax_number' => 'nullable|string|max:255|unique:employees',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'join_date' => 'required|date',
            'employment_status' => 'required|in:contract,permanent,probation,internship',
            'status' => 'required|in:active,inactive,terminated',
            'basic_salary' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'emergency_contact_relation' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position']);
        
        // Get attendance statistics
        $totalAttendances = $employee->attendances()->count();
        $presentCount = $employee->attendances()->where('status', 'present')->count();
        $lateCount = $employee->attendances()->where('status', 'late')->count();
        $absentCount = $employee->attendances()->where('status', 'absent')->count();
        $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 2) : 0;
        
        // Get recent attendances
        $recentAttendances = $employee->attendances()
            ->latest('date')
            ->take(10)
            ->get();
        
        // Get leave statistics
        $totalLeaves = $employee->leaves()->count();
        $approvedLeaves = $employee->leaves()->where('status', 'approved')->count();
        $pendingLeaves = $employee->leaves()->where('status', 'pending')->count();
        $rejectedLeaves = $employee->leaves()->where('status', 'rejected')->count();
        
        // Get recent leaves
        $recentLeaves = $employee->leaves()
            ->latest()
            ->take(5)
            ->get();
        
        // Get payroll statistics
        $latestPayroll = $employee->payrolls()
            ->latest('period')
            ->first();
        
        $recentPayrolls = $employee->payrolls()
            ->latest('period')
            ->take(6)
            ->get();
        
        return view('employees.show', compact(
            'employee',
            'totalAttendances',
            'presentCount',
            'lateCount',
            'absentCount',
            'attendanceRate',
            'recentAttendances',
            'totalLeaves',
            'approvedLeaves',
            'pendingLeaves',
            'rejectedLeaves',
            'recentLeaves',
            'latestPayroll',
            'recentPayrolls'
        ));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_number' => 'required|unique:employees,employee_number,' . $employee->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'id_card_number' => 'nullable|string|max:255|unique:employees,id_card_number,' . $employee->id,
            'tax_number' => 'nullable|string|max:255|unique:employees,tax_number,' . $employee->id,
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'join_date' => 'required|date',
            'employment_status' => 'required|in:contract,permanent,probation,internship',
            'status' => 'required|in:active,inactive,terminated',
            'basic_salary' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'emergency_contact_relation' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
