<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ ApplicationStage::getStageNames()[$stage] ?? $stage }}</h1>
                <p class="text-gray-600 mt-2">{{ $job->vacancy_title }} - {{ $job->code }}</p>
            </div>
            <a href="{{ route('hrd.recruitment.process', $job_id) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                ← Back to Process
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Toolbar -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- Left: Search & Sort -->
            <div class="flex items-center gap-3 flex-1">
                <!-- Search -->
                <div class="flex-1 max-w-md">
                    <input type="text" wire:model.live.debounce.300ms="search" 
                        placeholder="Search candidates..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Sort -->
                <select wire:model.live="sortBy" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="name_asc">Name A-Z</option>
                </select>

                <!-- Filter Button -->
                <button wire:click="$set('showFilterModal', true)" 
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                </button>
            </div>

            <!-- Right: Bulk Actions -->
            @if(count($selectedCandidates) > 0)
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">{{ count($selectedCandidates) }} selected</span>
                    <button wire:click="$set('bulkActionModal', 'pass')" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        ✅ Pass All
                    </button>
                    <button wire:click="$set('bulkActionModal', 'reject')" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        ❌ Reject All
                    </button>
                </div>
            @endif
        </div>

        <!-- Select All -->
        <div class="mt-3 pt-3 border-t border-gray-200">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Select All Candidates</span>
            </label>
        </div>
    </div>

    <!-- Candidates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($candidates as $candidate)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow {{ in_array($candidate->id, $selectedCandidates) ? 'ring-2 ring-blue-500' : '' }}">
                <!-- Checkbox -->
                <div class="flex items-start justify-between mb-4">
                    <input type="checkbox" 
                        wire:click="toggleCandidate({{ $candidate->id }})"
                        {{ in_array($candidate->id, $selectedCandidates) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    
                    <span class="text-xs text-gray-500">
                        Applied: {{ $candidate->application->created_at->format('d M Y') }}
                    </span>
                </div>

                <!-- Candidate Info -->
                <div class="text-center mb-4">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl mx-auto mb-3">
                        {{ strtoupper(substr($candidate->application->user->name, 0, 2)) }}
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $candidate->application->user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $candidate->application->user->email }}</p>
                </div>

                <!-- Details -->
                @if($candidate->application->applicantIdentity)
                    <div class="space-y-2 text-sm mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Age:</span>
                            <span class="font-semibold">
                                {{ $candidate->application->applicantIdentity->date_of_birth ? 
                                   \Carbon\Carbon::parse($candidate->application->applicantIdentity->date_of_birth)->age . ' years' : 
                                   'N/A' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Education:</span>
                            <span class="font-semibold">{{ $candidate->application->applicantIdentity->last_education ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">GPA:</span>
                            <span class="font-semibold">{{ $candidate->application->applicantIdentity->gpa ?? 'N/A' }}</span>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-2">
                    <button wire:click="viewCandidate({{ $candidate->id }})" 
                        class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm">
                        View Profile
                    </button>
                    <button wire:click="startReview({{ $candidate->id }})" 
                        class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Review
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Candidates</h3>
                <p class="text-gray-600">There are no candidates at this stage yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Review Modal -->
    @if($reviewingCandidate)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Review Candidate</h2>
                        <button wire:click="$set('reviewingCandidate', null)" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Candidate Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xl">
                                {{ strtoupper(substr($reviewingCandidate->application->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $reviewingCandidate->application->user->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $reviewingCandidate->application->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Checklist -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Review Checklist:</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">CV Complete & Updated?</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Documents Valid?</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Contact Info Verified?</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Education Requirements Met?</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Experience Requirements Met?</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">All Mandatory Fields Complete?</span>
                            </label>
                        </div>
                    </div>

                    <!-- Review Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Review Notes</label>
                        <textarea wire:model="reviewNotes" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Add your review notes here..."></textarea>
                    </div>

                    <!-- Rejection Reason -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason (if rejecting)</label>
                        <select wire:model="rejectionReason" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select reason...</option>
                            <option value="incomplete_documents">Incomplete Documents</option>
                            <option value="not_meeting_requirements">Not Meeting Requirements</option>
                            <option value="duplicate_application">Duplicate Application</option>
                            <option value="overqualified">Overqualified</option>
                            <option value="underqualified">Underqualified</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button wire:click="$set('reviewingCandidate', null)" 
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button wire:click="markAsFailed" 
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            ❌ Reject
                        </button>
                        <button wire:click="markAsPassed" 
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            ✅ Pass
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bulk Pass Modal -->
    @if($bulkActionModal === 'pass')
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Confirm Bulk Pass</h3>
                <p class="text-gray-600 mb-6">
                    Are you sure you want to pass <strong>{{ count($selectedCandidates) }} candidates</strong> and move them to the next stage?
                </p>
                <div class="flex gap-3">
                    <button wire:click="$set('bulkActionModal', null)" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="bulkPass" 
                        class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Confirm Pass All
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Bulk Reject Modal -->
    @if($bulkActionModal === 'reject')
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Confirm Bulk Reject</h3>
                <p class="text-gray-600 mb-4">
                    You are about to reject <strong>{{ count($selectedCandidates) }} candidates</strong>.
                </p>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason *</label>
                    <select wire:model="rejectionReason" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select reason...</option>
                        <option value="incomplete_documents">Incomplete Documents</option>
                        <option value="not_meeting_requirements">Not Meeting Requirements</option>
                        <option value="duplicate_application">Duplicate Application</option>
                        <option value="overqualified">Overqualified</option>
                        <option value="underqualified">Underqualified</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button wire:click="$set('bulkActionModal', null)" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="bulkReject" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Confirm Reject All
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- View Profile Modal -->
    @if($viewingCandidate)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Candidate Profile</h2>
                        <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 mb-6 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl">
                                {{ strtoupper(substr($viewingCandidate->application->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{ $viewingCandidate->application->user->name }}</h3>
                                <p class="text-blue-100">{{ $viewingCandidate->application->user->email }}</p>
                                <p class="text-sm text-blue-100 mt-1">
                                    Applied: {{ $viewingCandidate->application->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    @if($viewingCandidate->application->applicantIdentity)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Info -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Personal Information</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">NIK:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->national_id_number }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Date of Birth:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->date_of_birth }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Age:</span>
                                        <span class="font-semibold">
                                            {{ \Carbon\Carbon::parse($viewingCandidate->application->applicantIdentity->date_of_birth)->age }} years
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Gender:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->gender }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->phone_number }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Education</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Last Education:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->last_education }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Institution:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->institution_name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Major:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->major ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">GPA:</span>
                                        <span class="font-semibold">{{ $viewingCandidate->application->applicantIdentity->gpa ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-3">
                        <button wire:click="closeViewModal" 
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Close
                        </button>
                        <button wire:click="startReview({{ $viewingCandidate->id }})" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Start Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
