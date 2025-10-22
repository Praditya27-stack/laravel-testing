<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Request Hiring Approval</h1>
            <p class="mt-1 text-sm text-gray-600">Submit hiring approval request to PIC Recruitment</p>
        </div>
        <a href="{{ route('hrd.hiring-approval.status') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            View Approval Status →
        </a>
    </div>

    @if(!$applicationId)
    <!-- Select Candidate -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Select Candidate</h2>
        
        <div class="space-y-3">
            @forelse($candidates as $candidate)
            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer" wire:click="selectCandidate({{ $candidate->id }})">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $candidate->user->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $candidate->user->email }}</p>
                        <p class="text-sm text-gray-500">Position: {{ $candidate->job->vacancy_title ?? $candidate->job->title }}</p>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                        Ready for Approval
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <p class="font-semibold">No candidates ready for hiring approval</p>
            </div>
            @endforelse
        </div>
    </div>
    @else
    <!-- Approval Form -->
    <form wire:submit.prevent="submitRequest">
        <!-- Candidate Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Candidate Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-semibold">{{ $application->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-semibold">{{ $application->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Applied Position</p>
                    <p class="font-semibold">{{ $application->job->vacancy_title ?? $application->job->title }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">MCU Result</p>
                    <p class="font-semibold text-green-600">✓ Fit for Work</p>
                </div>
            </div>
        </div>

        <!-- Offer Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Offer Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Salary Offered (IDR) <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="salary_offered" class="w-full px-4 py-2 border rounded-lg" placeholder="5000000">
                    @error('salary_offered') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position Title <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="position_title" class="w-full px-4 py-2 border rounded-lg">
                    @error('position_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="department" class="w-full px-4 py-2 border rounded-lg">
                    @error('department') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Employment Type <span class="text-red-500">*</span></label>
                    <select wire:model="employment_type" class="w-full px-4 py-2 border rounded-lg">
                        <option value="permanent">Permanent</option>
                        <option value="contract">Contract</option>
                        <option value="internship">Internship</option>
                    </select>
                    @error('employment_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                @if($employment_type === 'contract')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contract Duration (Months) <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="contract_duration_months" class="w-full px-4 py-2 border rounded-lg" placeholder="12">
                    @error('contract_duration_months') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Join Date <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="join_date" class="w-full px-4 py-2 border rounded-lg" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    @error('join_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Briefing/Onboarding Date</label>
                    <input type="date" wire:model="briefing_date" class="w-full px-4 py-2 border rounded-lg">
                    @error('briefing_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Benefits Package</label>
                    <textarea wire:model="benefits_package" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="BPJS Kesehatan, BPJS Ketenagakerjaan, Tunjangan Transport, dll"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                    <textarea wire:model="additional_notes" rows="2" class="w-full px-4 py-2 border rounded-lg" placeholder="Any additional information..."></textarea>
                </div>
            </div>
        </div>

        <!-- Select Approver -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Select Approver (PIC Recruitment) <span class="text-red-500">*</span></h2>
            
            <select wire:model="approver_id" class="w-full px-4 py-2 border rounded-lg">
                <option value="">-- Select PIC Recruitment --</option>
                @foreach($approvers as $approver)
                    <option value="{{ $approver->id }}">{{ $approver->name }} - {{ $approver->email }}</option>
                @endforeach
            </select>
            @error('approver_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('hrd.hiring-approval.status') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
            <button type="button" wire:click="openPreview" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Preview
            </button>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Submit Approval Request
            </button>
        </div>
    </form>
    @endif

    <!-- Preview Modal -->
    @if($showPreview && $application)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-8 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Preview Approval Request</h3>
                <button wire:click="$set('showPreview', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="border-b pb-3">
                    <h4 class="font-semibold mb-2">Candidate</h4>
                    <p>{{ $application->user->name }}</p>
                </div>
                <div class="border-b pb-3">
                    <h4 class="font-semibold mb-2">Position & Salary</h4>
                    <p>{{ $position_title }} - Rp {{ number_format($salary_offered, 0, ',', '.') }}</p>
                </div>
                <div class="border-b pb-3">
                    <h4 class="font-semibold mb-2">Department</h4>
                    <p>{{ $department }}</p>
                </div>
                <div class="border-b pb-3">
                    <h4 class="font-semibold mb-2">Join Date</h4>
                    <p>{{ \Carbon\Carbon::parse($join_date)->format('d F Y') }}</p>
                </div>
                <div class="border-b pb-3">
                    <h4 class="font-semibold mb-2">Approver</h4>
                    <p>{{ $approvers->find($approver_id)?->name }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
