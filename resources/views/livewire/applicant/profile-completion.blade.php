<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-6">
            <!-- Left Sidebar - Progress & Navigation -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                    <!-- Progress Header -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Kelengkapan Data:</h3>
                        <div class="flex items-center gap-2">
                            @if($completionPercentage >= 100)
                                <span class="text-lg font-bold text-green-600">Lengkap ✓</span>
                            @else
                                <span class="text-lg font-bold text-orange-600">Kurang</span>
                            @endif
                        </div>
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $completionPercentage }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $completionPercentage }}% Complete</p>
                        </div>
                        @if($completionPercentage < 100)
                        <p class="text-xs text-gray-600 mt-3">Datamu masih kurang lengkap untuk melamar pekerjaan. Segera lengkapi profilmu, khususnya data yang diwajibkan (*)!</p>
                        @endif
                    </div>

                    <!-- Section Navigation -->
                    <nav class="space-y-1">
                        <button wire:click="setActiveSection('identity')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'identity' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>A. Identitas</span>
                            @if(auth()->user()->identity && auth()->user()->identity->full_name)
                                <span class="text-green-500">✓</span>
                            @else
                                <span class="text-red-500">⚠</span>
                            @endif
                        </button>

                        <button wire:click="setActiveSection('education')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'education' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>B. Pendidikan</span>
                            <span class="text-red-500">⚠</span>
                        </button>

                        <button wire:click="setActiveSection('family')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'family' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>C. Keluarga</span>
                            <span class="text-red-500">⚠</span>
                        </button>

                        <button wire:click="setActiveSection('work')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'work' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>D. Riwayat Pekerjaan</span>
                            <span class="text-red-500">⚠</span>
                        </button>

                        <button wire:click="setActiveSection('motivation')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'motivation' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>E. Minat & Konsep</span>
                            <span class="text-red-500">⚠</span>
                        </button>

                        <button wire:click="setActiveSection('references')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'references' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>F. Background Check</span>
                            <span class="text-red-500">⚠</span>
                        </button>

                        <button wire:click="setActiveSection('others')" class="w-full flex items-center justify-between px-3 py-2 text-sm rounded hover:bg-gray-50 {{ $activeSection === 'others' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700' }}">
                            <span>G. Lain-lain</span>
                            <span class="text-red-500">⚠</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1">
                @if(session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6">
                    <p class="text-green-800">{{ session('message') }}</p>
                </div>
                @endif
                @if(session()->has('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-6">
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
                @endif

                <div class="bg-white rounded-lg shadow">
                    <!-- Section Header -->
                    <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">
                            @if($activeSection === 'personal') Biodata
                            @elseif($activeSection === 'education') Pendidikan
                            @elseif($activeSection === 'experience') Pengalaman & Minat Kerja
                            @elseif($activeSection === 'skills') Keahlian & Organisasi
                            @elseif($activeSection === 'documents') Dokumen
                            @elseif($activeSection === 'references') Referensi
                            @endif
                        </h2>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Ubah Data
                        </button>
                    </div>

                    <!-- Section Content -->
                    <div class="p-6">
                        @if($activeSection === 'identity')
                            @include('livewire.applicant.sections.identity')
                        @elseif($activeSection === 'education')
                            @include('livewire.applicant.sections.education-full')
                        @elseif($activeSection === 'family')
                            @include('livewire.applicant.sections.family')
                        @elseif($activeSection === 'work')
                            @include('livewire.applicant.sections.work-history')
                        @elseif($activeSection === 'motivation')
                            @include('livewire.applicant.sections.motivation')
                        @elseif($activeSection === 'references')
                            @include('livewire.applicant.sections.references')
                        @elseif($activeSection === 'others')
                            @include('livewire.applicant.sections.others')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
