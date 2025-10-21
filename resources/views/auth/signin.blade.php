@extends('layouts.landing')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Sign In</h2>
                <p class="mt-2 text-gray-600">Masuk ke akun Anda</p>
            </div>

            <!-- Sign In Form Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                @livewire('auth.sign-in')
            </div>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('signup') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Daftar di sini
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
