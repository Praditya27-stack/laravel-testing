<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">📧 Kirim Undangan Psychotest</h1>
        <p class="text-gray-600 mt-2">{{ $job->vacancy_title }} - {{ $job->code }}</p>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            @foreach(['1' => 'Pilih Kandidat', '2' => 'Jenis Test', '3' => 'Jadwal & Detail', '4' => 'Preview & Kirim'] as $step => $label)
                <div class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $currentStep >= $step ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            {{ $step }}
                        </div>
                        <span class="ml-3 font-medium {{ $currentStep >= $step ? 'text-blue-600' : 'text-gray-600' }}">{{ $label }}</span>
                    </div>
                    @if(!$loop->last)
                        <div class="flex-1 h-1 mx-4 {{ $currentStep > $step ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Step Content -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- STEP 1: Select Candidates -->
        @if($currentStep === 1)
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Pilih Kandidat</h2>
                <p class="text-gray-600 mb-6">Pilih kandidat yang akan diundang untuk mengikuti psychotest</p>

                <!-- Select All -->
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 font-medium text-gray-700">Pilih Semua Kandidat ({{ $candidates->count() }})</span>
                    </label>
                </div>

                <!-- Candidates Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($candidates as $candidate)
                        <div class="border rounded-lg p-4 {{ in_array($candidate->id, $selectedCandidates) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" 
                                    wire:model.live="selectedCandidates" 
                                    value="{{ $candidate->id }}"
                                    class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-gray-900">{{ $candidate->application->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $candidate->application->user->email }}</p>
                                    @if($candidate->application->applicantIdentity)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $candidate->application->applicantIdentity->last_education }}
                                        </p>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500">Tidak ada kandidat yang lolos tahap sebelumnya</p>
                        </div>
                    @endforelse
                </div>

                @error('selectedCandidates')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <!-- STEP 2: Choose Test Types -->
        @if($currentStep === 2)
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Pilih Jenis Test</h2>
                <p class="text-gray-600 mb-6">
                    Tingkat Pendidikan: <strong>{{ $educationLevel }}</strong> 
                    <span class="text-sm">({{ count($selectedCandidates) }} kandidat dipilih)</span>
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($testTypes as $key => $label)
                        <div class="border rounded-lg p-4 {{ in_array($key, $selectedTestTypes) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                    wire:model.live="selectedTestTypes" 
                                    value="{{ $key }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 font-medium text-gray-900">{{ $label }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>

                @error('selectedTestTypes')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <!-- STEP 3: Schedule & Details -->
        @if($currentStep === 3)
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Jadwal & Detail Test</h2>
                
                <div class="space-y-6">
                    <!-- Test Location -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Test</label>
                        <div class="flex gap-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="testLocation" value="online" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2">🌐 Online</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="testLocation" value="onsite" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2">🏢 Onsite</span>
                            </label>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Test *</label>
                            <input type="date" wire:model="scheduledDate" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('scheduledDate') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Test *</label>
                            <input type="time" wire:model="scheduledTime" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('scheduledTime') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Expiry & Passing Grade -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Masa Berlaku Link (Hari) *</label>
                            <input type="number" wire:model="expiryDays" min="1" max="7"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 7 hari</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Passing Grade (%) *</label>
                            <input type="number" wire:model="passingGrade" min="0" max="100"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('passingGrade') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Guide PDF -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Panduan Test (PDF)</label>
                        <input type="file" wire:model="guidePdf" accept=".pdf"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Upload file PDF panduan test untuk kandidat</p>
                    </div>

                    <!-- Hotline Contact -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Hotline Contact *</label>
                        <input type="text" wire:model="hotlineContact" placeholder="0812-3456-7890"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('hotlineContact') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- STEP 4: Preview & Send -->
        @if($currentStep === 4)
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Preview Undangan</h2>
                
                <div class="space-y-6">
                    <!-- Summary -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-900 mb-2">📊 Ringkasan</h3>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Jumlah Kandidat: <strong>{{ count($selectedCandidates) }}</strong></li>
                            <li>• Jenis Test: <strong>{{ count($selectedTestTypes) }} test</strong></li>
                            <li>• Jadwal: <strong>{{ $scheduledDate }} {{ $scheduledTime }}</strong></li>
                            <li>• Lokasi: <strong>{{ $testLocation === 'online' ? 'Online' : 'Onsite' }}</strong></li>
                            <li>• Passing Grade: <strong>{{ $passingGrade }}%</strong></li>
                        </ul>
                    </div>

                    <!-- Email Preview -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">📧 Preview Email</h3>
                        <div class="bg-gray-50 p-4 rounded">
                            <p class="font-semibold text-gray-900 mb-2">Subject: {{ $emailSubject }}</p>
                            <div class="text-sm text-gray-700 whitespace-pre-line">{{ $emailBody }}</div>
                        </div>
                    </div>

                    <!-- WhatsApp Preview -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">💬 Preview WhatsApp</h3>
                        <div class="bg-green-50 p-4 rounded">
                            <div class="text-sm text-gray-700 whitespace-pre-line">{{ $whatsappMessage }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            @if($currentStep > 1)
                <button wire:click="previousStep" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    ← Kembali
                </button>
            @else
                <a href="{{ route('hrd.recruitment.stage', ['job_id' => $job_id, 'stage' => $stage]) }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    ← Batal
                </a>
            @endif

            @if($currentStep < 4)
                <button wire:click="nextStep" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Lanjut →
                </button>
            @else
                <button wire:click="sendInvitations" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    ✅ Kirim Undangan
                </button>
            @endif
        </div>
    </div>
</div>
