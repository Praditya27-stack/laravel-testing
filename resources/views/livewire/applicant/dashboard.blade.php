<div>
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 mt-2">Dashboard Pelamar - PT Aisin Indonesia</p>
    </div>

    <!-- Profile Completion Alert -->
    @if($profile_completion < 100)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6 rounded-lg bg-gray-50">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-lg font-semibold text-yellow-800">Profil Belum Lengkap</h3>
                    <p class="text-yellow-700 mt-1">Lengkapi profil Anda untuk dapat melamar pekerjaan.</p>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-yellow-800">Kelengkapan Profil</span>
                            <span class="text-sm font-bold text-yellow-800">{{ $profile_completion }}%</span>
                        </div>
                        <div class="w-full bg-yellow-200 rounded-full h-3">
                            <div class="bg-yellow-600 h-3 rounded-full transition-all duration-300" style="width: {{ $profile_completion }}%"></div>
                        </div>
                    </div>

                    <a href="{{ route('applicant.profile.complete') }}" class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 font-semibold">
                        Lengkapi Profil Sekarang
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-green-800">Profil Lengkap 100%!</h3>
                    <p class="text-green-700">Anda sudah dapat melamar pekerjaan yang tersedia.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Action 1: Browse Jobs -->
        <a href="{{ route('jobs.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border-2 border-transparent hover:border-blue-500">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-gray-900">Cari Lowongan</h3>
                    <p class="text-gray-600 text-sm">Browse & apply jobs</p>
                </div>
            </div>
        </a>

        <!-- Action 2: Application History -->
        <a href="{{ route('applicant.applications.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border-2 border-transparent hover:border-green-500">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Lamaran</h3>
                    <p class="text-gray-600 text-sm">{{ $applications_count }} total applications</p>
                </div>
            </div>
        </a>

        <!-- Action 3: Edit Profile -->
        <a href="{{ route('applicant.profile.complete') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border-2 border-transparent hover:border-purple-500">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-gray-900">Edit Profil</h3>
                    <p class="text-gray-600 text-sm">Update your information</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-blue-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm">Total Lamaran</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $applications_count }}</h3>
                </div>
                <div class="bg-blue-400 bg-opacity-50 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-green-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-green-100 text-sm">Lamaran Aktif</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $active_applications }}</h3>
                </div>
                <div class="bg-green-400 bg-opacity-50 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-purple-600 rounded-lg shadow-md p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-purple-100 text-sm">Kelengkapan Profil</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $profile_completion }}%</h3>
                </div>
                <div class="bg-purple-400 bg-opacity-50 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Lamaran Terbaru</h2>

        @if($recent_applications->count() > 0)
            <div class="space-y-4">
                @foreach($recent_applications as $application)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $application->job->title ?? 'Job Title' }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $application->application_number }}</p>
                                <p class="text-sm text-gray-500 mt-1">Dilamar: {{ $application->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="ml-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($application->current_stage == 'applied') bg-blue-100 text-blue-800
                                    @elseif($application->current_stage == 'interview') bg-purple-100 text-purple-800
                                    @elseif($application->current_stage == 'hired') bg-green-100 text-green-800
                                    @elseif($application->current_stage == 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($application->current_stage) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('applicant.applications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('applicant.applications.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Lihat Semua Lamaran →
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada lamaran</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai melamar pekerjaan yang tersedia.</p>
                <div class="mt-6">
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Cari Lowongan
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
