<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP HRD System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">
    <div class="relative min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">ERP HRD System</h1>
                <p class="text-lg text-gray-600 mb-8">Human Resource Management System</p>
                
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
