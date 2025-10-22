<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Monitoring Ongoing Psychotest</h1>
            <p class="mt-1 text-sm text-gray-600">Real-time tracking psychotest candidates</p>
        </div>
        <a href="{{ route('hrd.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-600">Total</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['total'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-blue-600">Sent</div>
            <div class="mt-2 text-3xl font-bold text-blue-900">{{ $statistics['sent'] }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-yellow-600">Ongoing</div>
            <div class="mt-2 text-3xl font-bold text-yellow-900">{{ $statistics['ongoing'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Completed</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['completed'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-red-600">Not Attended</div>
            <div class="mt-2 text-3xl font-bold text-red-900">{{ $statistics['not_attended'] }}</div>
        </div>
        <div class="bg-purple-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-purple-600">Attendance Rate</div>
            <div class="mt-2 text-3xl font-bold text-purple-900">{{ $statistics['attendance_rate'] }}%</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        <option value="{{ $job->id }}">{{ $job->vacancy_title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Status</option>
                    <option value="sent">Sent</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="not_attended">Not Attended</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Test Type</label>
                <select wire:model.live="filterTestType" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Types</option>
                    <option value="smk">SMK</option>
                    <option value="d3_s1">D3/S1</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($invitations as $invitation)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $invitation->application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $invitation->application->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $invitation->application->job->vacancy_title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $invitation->test_type === 'smk' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ strtoupper($invitation->test_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $invitation->test_date->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($invitation->status === 'sent')
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Sent</span>
                        @elseif($invitation->status === 'ongoing')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Ongoing</span>
                        @elseif($invitation->status === 'completed')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Not Attended</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button wire:click="viewDetail({{ $invitation->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                        @if($invitation->status === 'sent')
                            <button wire:click="markAsOngoing({{ $invitation->id }})" class="text-yellow-600 hover:text-yellow-900">Start</button>
                            <button wire:click="markAsNotAttended({{ $invitation->id }})" class="text-red-600 hover:text-red-900">No Show</button>
                        @elseif($invitation->status === 'ongoing')
                            <button wire:click="markAsCompleted({{ $invitation->id }})" class="text-green-600 hover:text-green-900">Complete</button>
                        @endif
                        <button wire:click="resendInvitation({{ $invitation->id }})" class="text-gray-600 hover:text-gray-900">Resend</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No psychotest invitations found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t">
            {{ $invitations->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedInvitation)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Psychotest Detail</h3>
                <button wire:click="$set('showDetailModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Candidate</label>
                    <p class="text-lg font-semibold">{{ $selectedInvitation->application->user->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Job Position</label>
                    <p class="text-lg">{{ $selectedInvitation->application->job->vacancy_title }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Test Type</label>
                        <p class="text-lg">{{ strtoupper($selectedInvitation->test_type) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <p class="text-lg font-semibold">{{ ucfirst($selectedInvitation->status) }}</p>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Test Date & Time</label>
                    <p class="text-lg">{{ $selectedInvitation->test_date->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Location</label>
                    <p class="text-lg">{{ $selectedInvitation->test_location }}</p>
                </div>
                @if($selectedInvitation->session)
                <div class="border-t pt-4">
                    <label class="text-sm font-medium text-gray-600">Session Info</label>
                    <p>Started: {{ $selectedInvitation->session->started_at?->format('d M Y H:i') ?? '-' }}</p>
                    <p>Completed: {{ $selectedInvitation->session->completed_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
