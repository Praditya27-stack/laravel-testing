@extends('layouts.landing')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Bergabunglah Bersama Kami
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    PT Aisin Indonesia - Membangun Karir, Membangun Masa Depan
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('jobs.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                        Lihat Lowongan Kerja
                    </a>
                    <a href="{{ route('signup') }}" class="bg-blue-500 text-white hover:bg-blue-400 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Bergabung dengan Kami?</h2>
            <p class="text-lg text-gray-600">PT Aisin Indonesia menawarkan lingkungan kerja yang profesional dan berkembang</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Karir yang Menjanjikan</h3>
                <p class="text-gray-600">Berbagai posisi tersedia dari operator hingga manajemen dengan jenjang karir yang jelas</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pelatihan & Pengembangan</h3>
                <p class="text-gray-600">Program pelatihan berkelanjutan untuk meningkatkan kompetensi dan skill karyawan</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lingkungan Kerja Profesional</h3>
                <p class="text-gray-600">Budaya kerja yang mendukung, fasilitas modern, dan tim yang solid</p>
            </div>
        </div>
    </div>

    <!-- How to Apply Section -->
    <div class="bg-blue-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Melamar</h2>
                <p class="text-lg text-gray-600">Proses pendaftaran yang mudah dan transparan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        1
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Daftar Akun</h3>
                    <p class="text-gray-600 text-sm">Buat akun dengan NIK dan data diri Anda</p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        2
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Lengkapi Profil</h3>
                    <p class="text-gray-600 text-sm">Isi data pendidikan, pengalaman, dan keluarga</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        3
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Pilih Lowongan</h3>
                    <p class="text-gray-600 text-sm">Cari dan pilih posisi yang sesuai</p>
                </div>

                <!-- Step 4 -->
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        4
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Kirim Lamaran</h3>
                    <p class="text-gray-600 text-sm">Submit lamaran dan tunggu proses seleksi</p>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('guide') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Lihat Panduan Lengkap →
                </a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Siap Memulai Karir Anda?</h2>
            <p class="text-lg text-gray-600 mb-8">
                Bergabunglah dengan ribuan karyawan PT Aisin Indonesia yang telah membangun karir sukses bersama kami
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('signup') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                    Daftar Sekarang
                </a>
                <a href="{{ route('jobs.index') }}" class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                    Lihat Lowongan
                </a>
            </div>
        </div>
    </div>
@endsection
