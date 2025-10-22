<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Schedule Medical Checkup</h1>
            <p class="mt-1 text-sm text-gray-600">Schedule MCU appointments for candidates</p>
        </div>
        <a href="{{ route('hrd.medical-checkup.status') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            View MCU Status →
        </a>
    </div>

    <!-- Select Candidates -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Step 1: Select Candidates</h2>
        
        <div class="mb-4 flex items-center">
            <input type="checkbox" wire:model.live="selectAll" class="mr-2">
            <label class="font-semibold">Select All ({{ count($candidates) }} candidates)</label>
        </div>

        <div class="space-y-3">
            @forelse($candidates as $candidate)
            <div class="border rounded-lg p-4 hover:bg-gray-50">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="selectedCandidates" value="{{ $candidate->id }}" class="mr-3">
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $candidate->user->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $candidate->user->email }}</p>
                                <p class="text-sm text-gray-500">Applied for: {{ $candidate->job->vacancy_title ?? $candidate->job->title }}</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                Ready for MCU
                            </span>
                        </div>
                    </div>
                </label>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="font-semibold">No candidates at Medical Checkup stage</p>
            </div>
            @endforelse
        </div>

        @error('selectedCandidates')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- MCU Details -->
    @if(count($selectedCandidates) > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Step 2: MCU Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">MCU Date <span class="text-red-500">*</span></label>
                <input type="date" wire:model="mcuDate" class="w-full px-4 py-2 border rounded-lg" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                @error('mcuDate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">MCU Time <span class="text-red-500">*</span></label>
                <input type="time" wire:model="mcuTime" class="w-full px-4 py-2 border rounded-lg">
                @error('mcuTime') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Clinic <span class="text-red-500">*</span></label>
                <select wire:model="clinicId" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">-- Select Clinic --</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}">{{ $clinic->name }} - {{ $clinic->city }}</option>
                    @endforeach
                </select>
                @error('clinicId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                
                @if($clinicId)
                    @php $selectedClinic = $clinics->find($clinicId); @endphp
                    @if($selectedClinic)
                    <div class="mt-3 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">Clinic Information</h4>
                        <p class="text-sm text-blue-800">📍 {{ $selectedClinic->address }}</p>
                        <p class="text-sm text-blue-800">📞 {{ $selectedClinic->phone }}</p>
                        @if($selectedClinic->map_link)
                            <a href="{{ $selectedClinic->map_link }}" target="_blank" class="text-sm text-blue-600 hover:underline">🗺️ View on Map</a>
                        @endif
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Requirements -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Step 3: MCU Requirements</h2>
        
        <div class="space-y-2 mb-4">
            @foreach($requirements as $index => $requirement)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <span class="text-sm text-gray-700">✓ {{ $requirement }}</span>
                <button wire:click="removeRequirement({{ $index }})" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endforeach
        </div>

        <div class="flex gap-2">
            <input type="text" wire:model="customRequirement" placeholder="Add custom requirement..." class="flex-1 px-4 py-2 border rounded-lg">
            <button wire:click="addCustomRequirement" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add
            </button>
        </div>
    </div>

    <!-- Summary & Actions -->
    <div class="bg-blue-50 rounded-lg shadow p-6">
        <h3 class="font-semibold text-blue-900 mb-3">Summary</h3>
        <div class="space-y-1 text-sm text-blue-800">
            <p>• {{ count($selectedCandidates) }} candidates selected</p>
            <p>• MCU Date: {{ $mcuDate ? \Carbon\Carbon::parse($mcuDate)->format('d M Y') : '-' }}</p>
            <p>• MCU Time: {{ $mcuTime ?? '-' }}</p>
            <p>• Clinic: {{ $clinicId ? $clinics->find($clinicId)->name : '-' }}</p>
            <p>• Requirements: {{ count($requirements) }} items</p>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button wire:click="openPreview" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Preview
            </button>
            <button wire:click="scheduleAll" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Schedule & Send Invitations ✓
            </button>
        </div>
    </div>
    @endif

    <!-- Preview Modal -->
    @if($showPreview)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Preview MCU Schedule</h3>
                <button wire:click="$set('showPreview', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($candidates->whereIn('id', $selectedCandidates) as $candidate)
                <div class="border rounded-lg p-4">
                    <p class="font-semibold text-gray-900">{{ $candidate->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $candidate->user->email }}</p>
                    <p class="text-sm text-gray-500">MCU: {{ \Carbon\Carbon::parse($mcuDate)->format('d M Y') }} at {{ $mcuTime }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
