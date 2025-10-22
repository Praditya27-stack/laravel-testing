@extends('layouts.landing')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Lowongan Kerja</h1>
            <p class="text-blue-100">Temukan posisi yang sesuai dengan keahlian Anda</p>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Posisi</label>
                    <input type="text" placeholder="Cari lowongan..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option>Semua Kategori</option>
                        <option>Operator</option>
                        <option>Staff</option>
                        <option>Supervisor</option>
                        <option>Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option>Semua Pendidikan</option>
                        <option>SMK</option>
                        <option>D3</option>
                        <option>S1</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Job Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $job->vacancy_title ?? $job->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $job->code }}</p>
                        </div>
                        @if($job->education_level)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                            {{ strtoupper($job->education_level) }}
                        </span>
                        @endif
                    </div>

                    <div class="space-y-2 mb-4">
                        @if($job->department || $job->function)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $job->function ?? $job->department }}
                        </div>
                        @endif
                        @if($job->location)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $job->location }}
                        </div>
                        @endif
                        @if($job->employment_type)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                        </div>
                        @endif
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-4">
                            @if($job->total_needed)
                            <div>
                                <p class="text-xs text-gray-500">Kuota</p>
                                <p class="text-lg font-bold text-gray-900">{{ $job->total_needed }} posisi</p>
                            </div>
                            @endif
                            <div class="text-right {{ !$job->total_needed ? 'ml-auto' : '' }}">
                                <p class="text-xs text-gray-500">Deadline</p>
                                @php
                                    $deadline = $job->end_date ?? $job->closing_at;
                                @endphp
                                @if($deadline)
                                    <p class="text-sm font-semibold text-red-600">{{ \Carbon\Carbon::parse($deadline)->format('d M Y') }}</p>
                                @else
                                    <p class="text-sm font-semibold text-gray-600">Open</p>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('signup') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                            Lamar Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Lowongan</h3>
                <p class="text-gray-600">Saat ini belum ada lowongan yang tersedia. Silakan cek kembali nanti.</p>
            </div>
            @endforelse
        </div>

        <!-- Info Box -->
        <div class="mt-12 bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pastikan Anda sudah membuat akun dan melengkapi profil sebelum melamar</li>
                            <li>Periksa kualifikasi yang dibutuhkan sebelum mengirim lamaran</li>
                            <li>Proses seleksi akan dilakukan sesuai dengan tahapan yang telah ditentukan</li>
                            <li>Tidak ada biaya apapun dalam proses rekrutmen</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
