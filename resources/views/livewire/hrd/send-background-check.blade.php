<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Send Background Check Form</h1>
            <p class="mt-1 text-sm text-gray-600">Send background check questionnaire to candidate referees</p>
        </div>
        <a href="{{ route('hrd.background-check.results') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Results
        </a>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center {{ $currentStep >= 1 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300' }}">
                    1
                </div>
                <span class="ml-2 font-semibold">Select Candidates</span>
            </div>
            <div class="flex-1 h-1 mx-4 {{ $currentStep >= 2 ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
            
            <div class="flex items-center {{ $currentStep >= 2 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300' }}">
                    2
                </div>
                <span class="ml-2 font-semibold">Select Referees</span>
            </div>
            <div class="flex-1 h-1 mx-4 {{ $currentStep >= 3 ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
            
            <div class="flex items-center {{ $currentStep >= 3 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300' }}">
                    3
                </div>
                <span class="ml-2 font-semibold">Configure & Send</span>
            </div>
        </div>
    </div>

    <!-- Step 1: Select Candidates -->
    @if($currentStep === 1)
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
                            <div class="text-right">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $candidate->referees->count() }} Referees
                                </span>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="font-semibold">No candidates at Background Check stage</p>
            </div>
            @endforelse
        </div>

        @error('selectedCandidates')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div class="mt-6 flex justify-end">
            <button wire:click="nextStep" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Next: Select Referees →
            </button>
        </div>
    </div>
    @endif

    <!-- Step 2: Select Referees -->
    @if($currentStep === 2)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Step 2: Select Referees</h2>
        
        <div class="space-y-6">
            @foreach($candidateReferees as $item)
            <div class="border rounded-lg p-4">
                <h3 class="font-bold text-gray-900 mb-3">{{ $item['application']->user->name }}</h3>
                
                <div class="space-y-2">
                    @forelse($item['referees'] as $referee)
                    <label class="flex items-start p-3 border rounded hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" 
                               wire:click="toggleReferee({{ $referee->id }})"
                               {{ in_array($referee->id, $selectedReferees) ? 'checked' : '' }}
                               class="mt-1 mr-3">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $referee->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $referee->relationship }} at {{ $referee->company }}</p>
                                    <p class="text-sm text-gray-500">{{ $referee->email }} • {{ $referee->phone }}</p>
                                </div>
                                @if($referee->is_primary)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full h-fit">Primary</span>
                                @endif
                            </div>
                        </div>
                    </label>
                    @empty
                    <p class="text-sm text-gray-500 italic">No referees added for this candidate</p>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>

        @error('selectedReferees')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div class="mt-6 flex justify-between">
            <button wire:click="previousStep" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                ← Previous
            </button>
            <button wire:click="nextStep" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Next: Configure & Send →
            </button>
        </div>
    </div>
    @endif

    <!-- Step 3: Configure & Send -->
    @if($currentStep === 3)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Step 3: Configure & Send</h2>
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link Expiry (Days)</label>
                <input type="number" wire:model="expiryDays" min="1" max="30" class="w-full px-4 py-2 border rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Link will expire in {{ $expiryDays }} days</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Send Method</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" wire:model="sendMethod" value="email" class="mr-2">
                        <span>Email Only</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="sendMethod" value="whatsapp" class="mr-2">
                        <span>WhatsApp Only</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="sendMethod" value="both" class="mr-2">
                        <span>Both Email & WhatsApp</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Custom Message (Optional)</label>
                <textarea wire:model="customMessage" rows="6" class="w-full px-4 py-2 border rounded-lg" placeholder="{{ $this->getDefaultMessage() }}"></textarea>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">Summary</h3>
                <p class="text-sm text-blue-800">• {{ count($selectedCandidates) }} candidates selected</p>
                <p class="text-sm text-blue-800">• {{ count($selectedReferees) }} referees will receive the form</p>
                <p class="text-sm text-blue-800">• Forms will be sent via {{ ucfirst(str_replace('_', ' & ', $sendMethod)) }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <button wire:click="previousStep" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                ← Previous
            </button>
            <div class="space-x-3">
                <button wire:click="openPreview" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Preview
                </button>
                <button wire:click="sendForms" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Send Forms ✓
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Preview Modal -->
    @if($showPreview)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Preview Recipients</h3>
                <button wire:click="$set('showPreview', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($previewData as $referee)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $referee->name }}</p>
                            <p class="text-sm text-gray-600">{{ $referee->email }} • {{ $referee->phone }}</p>
                            <p class="text-sm text-gray-500">For: {{ $referee->application->user->name }}</p>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full h-fit">
                            {{ ucfirst($sendMethod) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
