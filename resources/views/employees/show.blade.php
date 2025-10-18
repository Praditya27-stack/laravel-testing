<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employee Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('employees.edit', $employee) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit Employee
                </a>
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Employee Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                                {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $employee->full_name }}</h3>
                                <p class="text-lg text-gray-600">{{ $employee->position->name }}</p>
                                <p class="text-sm text-gray-500">{{ $employee->department->name }}</p>
                                <div class="mt-2 flex items-center space-x-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($employee->status == 'active') bg-green-100 text-green-800
                                        @elseif($employee->status == 'inactive') bg-gray-100 text-gray-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                    <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                        {{ ucfirst($employee->employment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Employee Number</p>
                            <p class="text-xl font-bold text-gray-900">{{ $employee->employee_number }}</p>
                            <p class="text-sm text-gray-500 mt-2">Joined</p>
                            <p class="text-sm font-medium text-gray-900">{{ $employee->join_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Attendance Rate -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Attendance Rate</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $attendanceRate }}%</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $totalAttendances }} total days</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Present Days -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Present</p>
                            <p class="text-3xl font-bold text-green-600">{{ $presentCount }}</p>
                            <p class="text-xs text-gray-500 mt-1">days</p>
                        </div>
                    </div>
                </div>

                <!-- Late Days -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Late</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $lateCount }}</p>
                            <p class="text-xs text-gray-500 mt-1">days</p>
                        </div>
                    </div>
                </div>

                <!-- Absent Days -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Absent</p>
                            <p class="text-3xl font-bold text-red-600">{{ $absentCount }}</p>
                            <p class="text-xs text-gray-500 mt-1">days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Gender</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->gender ? ucfirst($employee->gender) : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Birth Date</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->birth_date ? $employee->birth_date->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Birth Place</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->birth_place ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">ID Card Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->id_card_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tax Number (NPWP)</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->tax_number ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->address ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">City</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->city ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Province</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->province ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Employment Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Department</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->department->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Position</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->position->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Join Date</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->join_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Employment Status</p>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($employee->employment_status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Basic Salary</p>
                            <p class="mt-1 text-sm text-gray-900">Rp {{ number_format($employee->basic_salary, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($employee->status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Information -->
            @if($employee->bank_name || $employee->bank_account_number)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Bank Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Bank Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->bank_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Account Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->bank_account_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Account Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->bank_account_name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Emergency Contact -->
            @if($employee->emergency_contact_name)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Emergency Contact</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Phone</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Relation</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact_relation ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Attendance & Leave -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Attendance -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Attendance</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($recentAttendances as $attendance)
                            <div class="flex items-center justify-between border-b pb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $attendance->date->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-500">
                                        In: {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }} | 
                                        Out: {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($attendance->status == 'present') bg-green-100 text-green-800
                                    @elseif($attendance->status == 'late') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500">No attendance records found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Leaves -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Leave History</h3>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">{{ $approvedLeaves }}</span> Approved | 
                            <span class="font-medium">{{ $pendingLeaves }}</span> Pending
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($recentLeaves as $leave)
                            <div class="flex items-center justify-between border-b pb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($leave->leave_type) }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }} 
                                        ({{ $leave->total_days }} days)
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($leave->status == 'approved') bg-green-100 text-green-800
                                    @elseif($leave->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500">No leave records found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Payroll -->
            @if($latestPayroll || $recentPayrolls->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Payroll History</h3>
                </div>
                <div class="p-6">
                    @if($latestPayroll)
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Latest Payroll</p>
                                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($latestPayroll->net_salary, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 mt-1">Period: {{ $latestPayroll->period }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Gross: Rp {{ number_format($latestPayroll->gross_salary, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-600">Deduction: Rp {{ number_format($latestPayroll->total_deduction, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Gross</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deduction</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Net Salary</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($recentPayrolls as $payroll)
                                <tr>
                                    <td class="px-4 py-3">{{ $payroll->period }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($payroll->gross_salary, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 font-medium">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($payroll->status == 'paid') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($payroll->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No payroll records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
