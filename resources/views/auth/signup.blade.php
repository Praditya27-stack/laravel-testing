@extends('layouts.landing')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Daftar Akun Baru</h2>
                <p class="mt-2 text-gray-600">Bergabunglah dengan PT Aisin Indonesia</p>
            </div>

            <!-- Sign Up Form Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                @livewire('auth.sign-up')
            </div>

            <!-- Sign In Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('signin') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Sign In di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
