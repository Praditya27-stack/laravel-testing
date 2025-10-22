<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Background Check Results</h1>
            <p class="mt-1 text-sm text-gray-600">Review and assess background check responses</p>
        </div>
        <div class="space-x-3">
            <a href="{{ route('hrd.background-check.followup') }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                Follow-up Pending
            </a>
            <a href="{{ route('hrd.background-check.send') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Send New Form
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-600">Total Requests</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['total'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-blue-600">Sent</div>
            <div class="mt-2 text-3xl font-bold text-blue-900">{{ $statistics['sent'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Completed</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['completed'] }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-yellow-600">Pending</div>
            <div class="mt-2 text-3xl font-bold text-yellow-900">{{ $statistics['pending'] }}</div>
        </div>
        <div class="bg-purple-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-purple-600">Response Rate</div>
            <div class="mt-2 text-3xl font-bold text-purple-900">{{ $statistics['response_rate'] }}%</div>
        </div>
    </div>

    <!-- Assessment Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Passed</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['passed'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-red-600">Failed</div>
            <div class="mt-2 text-3xl font-bold text-red-900">{{ $statistics['failed'] }}</div>
        </div>
        <div class="bg-orange-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-orange-600">Need Review</div>
            <div class="mt-2 text-3xl font-bold text-orange-900">{{ $statistics['need_review'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-blue-600">Avg Rating</div>
            <div class="mt-2 text-3xl font-bold text-blue-900">{{ $statistics['avg_rating'] }}/5</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search candidate..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Job</label>
                <select wire:model.live="filterJob" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Jobs</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}">{{ $job->vacancy_title ?? $job->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Result</label>
                <select wire:model.live="filterResult" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Results</option>
                    <option value="passed">Passed</option>
                    <option value="failed">Failed</option>
                    <option value="pending">Pending</option>
                    <option value="need_more_info">Need More Info</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ratings</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recommend</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($responses as $response)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $response->request->application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $response->request->application->job->vacancy_title ?? $response->request->application->job->title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $response->request->referee->name }}</div>
                        <div class="text-sm text-gray-500">{{ $response->request->referee->relationship }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-lg font-bold text-gray-900">{{ $response->average_rating ?? '-' }}/5</div>
                        <div class="text-xs text-gray-500">Total: {{ $response->total_score ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($response->would_recommend === 'yes')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Yes</span>
                        @elseif($response->would_recommend === 'no')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">No</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Maybe</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($response->result)
                            @if($response->result->result === 'passed')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Passed</span>
                            @elseif($response->result->result === 'failed')
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Failed</span>
                            @elseif($response->result->result === 'need_more_info')
                                <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Need Info</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Not Assessed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button wire:click="viewDetail({{ $response->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                        <button wire:click="openAssessment({{ $response->id }})" class="text-green-600 hover:text-green-900">Assess</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No background check responses found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t">
            {{ $responses->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedResponse)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Background Check Details</h3>
                <button wire:click="$set('showDetailModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Candidate</label>
                        <p class="text-lg font-semibold">{{ $selectedResponse->request->application->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Referee</label>
                        <p class="text-lg font-semibold">{{ $selectedResponse->request->referee->name }}</p>
                        <p class="text-sm text-gray-500">{{ $selectedResponse->request->referee->relationship }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="font-semibold mb-3">Ratings (1-5 Scale)</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Work Performance:</span>
                            <span class="font-bold">{{ $selectedResponse->rating_work_performance }}/5</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Attendance:</span>
                            <span class="font-bold">{{ $selectedResponse->rating_attendance }}/5</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Teamwork:</span>
                            <span class="font-bold">{{ $selectedResponse->rating_teamwork }}/5</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Integrity:</span>
                            <span class="font-bold">{{ $selectedResponse->rating_integrity }}/5</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Communication:</span>
                            <span class="font-bold">{{ $selectedResponse->rating_communication }}/5</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Problem Solving:</span>
                            <span class="font-bold">{{ $selectedResponse->rating_problem_solving }}/5</span>
                        </div>
                    </div>
                    <div class="mt-4 bg-blue-50 p-4 rounded-lg">
                        <div class="flex justify-between">
                            <span class="font-semibold text-blue-900">Average Rating:</span>
                            <span class="text-2xl font-bold text-blue-900">{{ $selectedResponse->average_rating }}/5</span>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <label class="text-sm font-medium text-gray-600">Would Recommend?</label>
                    <p class="text-lg font-semibold">{{ ucfirst($selectedResponse->would_recommend) }}</p>
                </div>

                <div class="border-t pt-4">
                    <label class="text-sm font-medium text-gray-600">Reason for Leaving</label>
                    <p class="text-gray-900">{{ $selectedResponse->reason_for_leaving }}</p>
                </div>

                @if($selectedResponse->additional_comments)
                <div class="border-t pt-4">
                    <label class="text-sm font-medium text-gray-600">Additional Comments</label>
                    <p class="text-gray-900">{{ $selectedResponse->additional_comments }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Assessment Modal -->
    @if($showAssessmentModal && $selectedResponse)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-8 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Assess Background Check</h3>
                <button wire:click="$set('showAssessmentModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form wire:submit.prevent="saveAssessment">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Candidate: <span class="font-semibold">{{ $selectedResponse->request->application->user->name }}</span></p>
                        <p class="text-sm text-gray-600">Average Rating: <span class="font-semibold">{{ $selectedResponse->average_rating }}/5</span></p>
                        <p class="text-sm text-gray-600">Recommendation: <span class="font-semibold">{{ ucfirst($selectedResponse->would_recommend) }}</span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Decision</label>
                        <select wire:model="assessmentResult" class="w-full px-4 py-2 border rounded-lg">
                            <option value="passed">✓ Passed - Move to Medical Checkup</option>
                            <option value="failed">✗ Failed - Reject Application</option>
                            <option value="pending">⏳ Pending - Need More Time</option>
                            <option value="need_more_info">ℹ Need More Information</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">HR Notes</label>
                        <textarea wire:model="assessmentNotes" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="Add your assessment notes..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                        <textarea wire:model="additionalInfo" rows="2" class="w-full px-4 py-2 border rounded-lg" placeholder="Any additional info from follow-up calls..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="$set('showAssessmentModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Assessment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
