@extends('layouts.app')

@section('title', 'Dashboard - ERP HRD System')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800">ERP HRD</h1>
            <p class="text-sm text-gray-500">Human Resource</p>
        </div>
        
        <nav class="mt-6">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-500">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('employees.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Employees
            </a>
            
            <a href="{{ route('attendances.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Attendance
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-x-hidden overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-8 py-4">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, Admin</span>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Employees -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Employees</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalEmployees }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Departments -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Departments</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalDepartments }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Today's Attendance -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Today's Attendance</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $todayAttendance }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Leaves -->
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending Leaves</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $pendingLeaves }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Recent Employees -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Employees</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($recentEmployees as $employee)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $employee->full_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $employee->position->name }} - {{ $employee->department->name }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500">No employees found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Today's Attendance -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Today's Attendance</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($recentAttendances as $attendance)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $attendance->employee->full_name }}</p>
                                    <p class="text-sm text-gray-500">Check-in: {{ $attendance->check_in }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-medium 
                                    @if($attendance->status == 'present') text-green-700 bg-green-100
                                    @elseif($attendance->status == 'late') text-yellow-700 bg-yellow-100
                                    @else text-red-700 bg-red-100
                                    @endif
                                    rounded-full">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500">No attendance records today.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
