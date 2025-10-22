<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HRD Dashboard - ERP System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<style>
    .sidebar-link {
        transition: all 0.3s ease;
    }
    .sidebar-link:hover {
        background-color: #f9fafb;
    }
</style>
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800">ERP System</h1>
            <p class="text-sm text-gray-500 mt-1">Human Resources</p>
        </div>
        
        <nav class="mt-6 flex-1 overflow-y-auto">
            <!-- 1. RECRUITMENT ANALYTICS -->
            <div class="mb-2">
                <div class="px-6 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Analytics</h3>
                </div>
                <a href="{{ route('hrd.dashboard') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Recruitment Analytics
                </a>
            </div>

            <!-- 2. SETTINGS -->
            <div class="mb-2 mt-4">
                <div class="px-6 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                </div>
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Notification
                </a>
                <a href="{{ route('hrd.jobs.index') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    📢 Posting Job Vacancy
                </a>
            </div>

            <!-- 3. RECRUITMENT -->
            <div class="mb-2 mt-4">
                <div class="px-6 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Recruitment</h3>
                </div>
                <a href="{{ route('hrd.jobs.index') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600 font-semibold">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Recruitment Process ⭐
                </a>
                
                <!-- Online Psychotest Submenu -->
                <div class="ml-4 mt-2 border-l-2 border-gray-200">
                    <div class="px-6 py-2">
                        <p class="text-xs font-semibold text-gray-500">Online Psychotest</p>
                    </div>
                    <a href="{{ route('hrd.psychotest.monitoring') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Monitoring Ongoing
                    </a>
                    <a href="{{ route('hrd.psychotest.report') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Psychotest Report
                    </a>
                    <a href="{{ route('hrd.psychotest.download') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Download Report
                    </a>
                </div>

                <!-- Background Check Submenu -->
                <div class="ml-4 mt-2 border-l-2 border-gray-200">
                    <div class="px-6 py-2">
                        <p class="text-xs font-semibold text-gray-500">Background Check</p>
                    </div>
                    <a href="{{ route('hrd.background-check.send') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Send BGC Form
                    </a>
                    <a href="{{ route('hrd.background-check.results') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        BGC Results
                    </a>
                    <a href="{{ route('hrd.background-check.followup') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Follow-up Pending
                    </a>
                </div>

                <!-- Medical Checkup Submenu -->
                <div class="ml-4 mt-2 border-l-2 border-gray-200">
                    <div class="px-6 py-2">
                        <p class="text-xs font-semibold text-gray-500">Medical Checkup</p>
                    </div>
                    <a href="{{ route('hrd.medical-checkup.schedule') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Schedule MCU
                    </a>
                    <a href="{{ route('hrd.medical-checkup.status') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        MCU Status & Results
                    </a>
                </div>

                <!-- Hiring Approval Submenu -->
                <div class="ml-4 mt-2 border-l-2 border-gray-200">
                    <div class="px-6 py-2">
                        <p class="text-xs font-semibold text-gray-500">Hiring & Onboarding</p>
                    </div>
                    <a href="{{ route('hrd.hiring-approval.request') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Request Approval
                    </a>
                    <a href="{{ route('hrd.hiring-approval.status') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Approval Status
                    </a>
                    <a href="{{ route('hrd.hiring-approval.offer') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Generate Offer Letter
                    </a>
                    <a href="{{ route('hrd.hired-candidates') }}" class="sidebar-link flex items-center px-6 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Hired Candidates
                    </a>
                </div>
            </div>
        </nav>
        
        <div class="p-6 border-t">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Admin HRD' }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@erp.com' }}</p>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-8 py-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $title ?? 'HRD Dashboard' }}
                </h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-8">
            {{ $slot }}
        </div>
    </main>
</div>

@livewireScripts
</body>
</html>
