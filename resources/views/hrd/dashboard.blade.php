<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HRD Dashboard -  </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <h1 class="text-2xl font-bold text-gray-800">Human Resources </h1>
            <p class="text-sm text-gray-500 mt-1"></p>
        </div>

        <nav class="mt-6 flex-1 overflow-y-auto">
            <!-- 1. RECRUITMENT ANALYTICS -->
            <div class="mb-2">
                <div class="px-6 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Analytics</h3>
                </div>
                <a href="{{ route('hrd.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 bg-blue-50 border-r-4 border-blue-600">
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
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Email Reminder
                </a>
                <a href="{{ route('hrd.jobs.index') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Posting Job Vacancy
                </a>
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Form Lamaran Kerja
                </a>
            </div>

            <!-- 3. RECRUITMENT -->
            <div class="mb-2 mt-4">
                <div class="px-6 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Recruitment</h3>
                </div>
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600" title="Coming Soon">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Input Application
                    <span class="ml-auto text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Soon</span>
                </a>
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600" title="Coming Soon">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Candidate Pool
                    <span class="ml-auto text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Soon</span>
                </a>
                <a href="{{ route('hrd.jobs.index') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600 font-semibold">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Recruitment Process
                </a>
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Data
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
                    AD
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Admin HRD</p>
                    <p class="text-xs text-gray-500">admin@erp.com</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-8 py-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Recruitment Analytics</h2>
                    <p class="text-sm text-gray-500 mt-1">Visualisasi data dan progress recruitment</p>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700">{{ date('l, d F Y') }}</p>
                        <p class="text-xs text-gray-500" id="current-time"></p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="p-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Pelamar Bulan Ini -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pelamar Bulan Ini</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">156</h3>
                            <p class="text-xs text-green-600 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                +23% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Lolos Psychotest -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lolos Psychotest</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">89</h3>
                            <p class="text-xs text-gray-600 mt-2">
                                57% dari total pelamar
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Lolos User Interview -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lolos User Interview</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">42</h3>
                            <p class="text-xs text-orange-600 mt-2">
                                47% dari lolos psychotest
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Tahap Offering -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tahap Offering</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">18</h3>
                            <p class="text-xs text-purple-600 mt-2">
                                Siap untuk hired
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recruitment Chart -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">📊 Jumlah Pelamar Per Bulan</h3>
                        <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>6 Bulan Terakhir</option>
                            <option>12 Bulan Terakhir</option>
                            <option>Tahun Ini</option>
                        </select>
                    </div>

                    <div class="h-64">
                        <canvas id="recruitmentChart"></canvas>
                    </div>
                </div>

                <!-- Asal Sekolah/Universitas -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">🎓 Asal Sekolah/Universitas</h3>

                    <div class="space-y-4">
                        <p class="text-xs text-gray-500 mb-3">SMK (Top 5)</p>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">SMKN 1 Karawang</span>
                                <span class="text-sm font-semibold text-gray-800">28</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">SMKN 2 Karawang</span>
                                <span class="text-sm font-semibold text-gray-800">22</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 55%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">SMK Taruna Bhakti</span>
                                <span class="text-sm font-semibold text-gray-800">18</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 mb-3 mt-4">Universitas (Top 3)</p>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Universitas Indonesia</span>
                                <span class="text-sm font-semibold text-gray-800">15</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-600 h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Universitas Singaperbangsa</span>
                                <span class="text-sm font-semibold text-gray-800">12</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-pink-600 h-2 rounded-full" style="width: 48%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Politeknik Negeri Jakarta</span>
                                <span class="text-sm font-semibold text-gray-800">10</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: 40%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Pending Requests -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pengajuan Cuti Terbaru -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Pengajuan Cuti Terbaru</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                    </div>

                    <div class="space-y-4">
                        @for($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ ['BW', 'SA', 'RP', 'DK'][$i] }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">{{ ['Budi Wijaya', 'Siti Aminah', 'Rudi Pratama', 'Dewi Kartika'][$i] }}</p>
                                    <p class="text-xs text-gray-500">{{ ['Cuti Tahunan - 3 hari', 'Cuti Sakit - 2 hari', 'Izin Keluarga - 1 hari', 'Cuti Tahunan - 5 hari'][$i] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-lg hover:bg-green-200">
                                    Setuju
                                </button>
                                <button class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200">
                                    Tolak
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Aktivitas Terbaru -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Ahmad Fauzi</span> telah check-in
                                </p>
                                <p class="text-xs text-gray-500 mt-1">2 menit yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    Karyawan baru <span class="font-medium">Linda Susanti</span> ditambahkan
                                </p>
                                <p class="text-xs text-gray-500 mt-1">15 menit yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    Pengajuan cuti <span class="font-medium">Eko Prasetyo</span> disetujui
                                </p>
                                <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    Lowongan <span class="font-medium">Senior Developer</span> dipublikasikan
                                </p>
                                <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Maya Sari</span> terlambat check-in
                                </p>
                                <p class="text-xs text-gray-500 mt-1">3 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('current-time').textContent = timeString;
    }
    updateTime();
    setInterval(updateTime, 1000);

    // Attendance Chart
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Hadir',
                data: [235, 242, 238, 245, 240, 180, 0],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Terlambat',
                data: [8, 5, 7, 3, 6, 4, 0],
                borderColor: 'rgb(251, 146, 60)',
                backgroundColor: 'rgba(251, 146, 60, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Izin/Sakit',
                data: [5, 1, 3, 0, 2, 1, 0],
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    });
</script>
</body>
</html>
