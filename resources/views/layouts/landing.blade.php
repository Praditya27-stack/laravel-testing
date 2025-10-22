<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Recruitment Portal</title>
    
    <!-- Fonts (Local - NO CDN) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-blue-600">PT Aisin Indonesia</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('jobs.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Lowongan Kerja
                    </a>
                    <a href="{{ route('guide') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Panduan Pelamar
                    </a>
                    
                    @guest
                        <a href="{{ route('signin') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Sign In
                        </a>
                        <a href="{{ route('signup') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">
                            Sign Up
                        </a>
                    @else
                        <a href="{{ route('applicant.profile') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Profile
                        </a>
                        <a href="{{ route('applicant.applications') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            My Applications
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium">
                    Home
                </a>
                <a href="{{ route('jobs.index') }}" class="block text-gray-700 hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium">
                    Lowongan Kerja
                </a>
                <a href="{{ route('guide') }}" class="block text-gray-700 hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium">
                    Panduan Pelamar
                </a>
                @guest
                    <a href="{{ route('signin') }}" class="block text-gray-700 hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium">
                        Sign In
                    </a>
                    <a href="{{ route('signup') }}" class="block bg-blue-600 text-white hover:bg-blue-700 px-3 py-2 rounded-md text-base font-medium">
                        Sign Up
                    </a>
                @else
                    <a href="{{ route('applicant.profile') }}" class="block text-gray-700 hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium">
                        Profile
                    </a>
                    <a href="{{ route('applicant.applications') }}" class="block text-gray-700 hover:bg-blue-50 px-3 py-2 rounded-md text-base font-medium">
                        My Applications
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">PT Aisin Indonesia</h3>
                    <p class="text-gray-400 text-sm">
                        Leading automotive parts manufacturer in Indonesia
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('jobs.index') }}" class="text-gray-400 hover:text-white">Lowongan Kerja</a></li>
                        <li><a href="{{ route('guide') }}" class="text-gray-400 hover:text-white">Panduan Pelamar</a></li>
                        <li><a href="{{ route('signin') }}" class="text-gray-400 hover:text-white">Sign In</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <p class="text-gray-400 text-sm">
                        Email: recruitment@aisin.co.id<br>
                        Phone: (021) 1234-5678
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} PT Aisin Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
