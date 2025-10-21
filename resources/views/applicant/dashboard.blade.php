<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('applicant.dashboard') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-blue-600">PT Aisin Indonesia</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('applicant.dashboard') }}" class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold">
                        Dashboard
                    </a>
                    <a href="{{ route('jobs.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Lowongan
                    </a>
                    <a href="{{ route('applicant.applications.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Lamaran Saya
                    </a>
                    <a href="{{ route('applicant.profile.complete') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Profil
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="ml-4 pl-4 border-l border-gray-200 flex items-center space-x-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 px-3 py-2 rounded-lg text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('applicant.dashboard')
        </div>
    </main>

    @livewireScripts
</body>
</html>
