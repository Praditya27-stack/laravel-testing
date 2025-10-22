<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Job Header -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                    <p class="text-lg text-gray-600 mb-4">{{ $job->department }}</p>
                    
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $job->location }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ ucfirst($job->employment_type) }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Rp {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                        </span>
                    </div>
                </div>
                
                <div class="ml-6">
                    @auth
                        @if($hasApplied)
                            <button disabled class="px-6 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                ✓ Sudah Melamar
                            </button>
                        @elseif($canApply)
                            <a href="{{ route('applicant.job.apply', $job->id) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                                Lamar Sekarang
                            </a>
                        @else
                            <a href="{{ route('applicant.profile') }}" class="inline-block px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold">
                                Lengkapi Profil Dulu
                            </a>
                        @endif
                    @else
                        <a href="{{ route('signin') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                            Login untuk Melamar
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Job Details -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="space-y-8">
                <!-- Description -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Pekerjaan</h2>
                    <div class="text-gray-700 whitespace-pre-line">{{ $job->description }}</div>
                </div>

                <!-- Requirements -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Persyaratan</h2>
                    <div class="text-gray-700 whitespace-pre-line">{{ $job->requirements }}</div>
                </div>

                <!-- Responsibilities -->
                @if($job->responsibilities)
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tanggung Jawab</h2>
                    <div class="text-gray-700 whitespace-pre-line">{{ $job->responsibilities }}</div>
                </div>
                @endif

                <!-- Benefits -->
                @if($job->benefits)
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Benefit</h2>
                    <div class="text-gray-700 whitespace-pre-line">{{ $job->benefits }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                ← Kembali ke Daftar Lowongan
            </a>
        </div>
    </div>
</div>
