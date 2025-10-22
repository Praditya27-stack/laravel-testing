<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Hiring Approval Status</h1>
            <p class="mt-1 text-sm text-gray-600">Track and manage hiring approval requests</p>
        </div>
        <div class="space-x-3">
            <a href="{{ route('hrd.hiring-approval.offer') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Generate Offer Letter
            </a>
            <a href="{{ route('hrd.hiring-approval.request') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + New Request
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-600">Total Requests</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['total'] }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-yellow-600">Pending</div>
            <div class="mt-2 text-3xl font-bold text-yellow-900">{{ $statistics['pending'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Approved</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['approved'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-red-600">Rejected</div>
            <div class="mt-2 text-3xl font-bold text-red-900">{{ $statistics['rejected'] }}</div>
        </div>
        <div class="bg-orange-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-orange-600">Need Revision</div>
            <div class="mt-2 text-3xl font-bold text-orange-900">{{ $statistics['revision_needed'] }}</div>
        </div>
        <div class="bg-purple-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-purple-600">Approval Rate</div>
            <div class="mt-2 text-3xl font-bold text-purple-900">{{ $statistics['approval_rate'] }}%</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search candidate or approval number..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="revision_needed">Revision Needed</option>
                </select>
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
        </div>
    </div>

    <!-- Approvals Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approval #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approver</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($approvals as $approval)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ $approval->approval_number }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $approval->application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $approval->application->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $approval->position_title }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Rp {{ number_format($approval->salary_offered, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $approval->approver->name }}
                    </td>
                    <td class="px-6 py-4">
                        @if($approval->status === 'pending')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($approval->status === 'approved')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                        @elseif($approval->status === 'rejected')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Revision Needed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button wire:click="viewDetail({{ $approval->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                        @if($approval->status === 'pending')
                            <button wire:click="resendRequest({{ $approval->id }})" class="text-green-600 hover:text-green-900">Resend</button>
                            <button wire:click="cancelRequest({{ $approval->id }})" class="text-red-600 hover:text-red-900">Cancel</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        No approval requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t">
            {{ $approvals->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedApproval)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-8 border w-full max-w-3xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Approval Details</h3>
                <button wire:click="$set('showDetailModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-600">Approval Number:</span>
                        <p class="font-semibold">{{ $selectedApproval->approval_number }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Status:</span>
                        <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $selectedApproval->status)) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Candidate:</span>
                        <p class="font-semibold">{{ $selectedApproval->application->user->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Position:</span>
                        <p class="font-semibold">{{ $selectedApproval->position_title }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Department:</span>
                        <p class="font-semibold">{{ $selectedApproval->department }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Salary:</span>
                        <p class="font-semibold">Rp {{ number_format($selectedApproval->salary_offered, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Employment Type:</span>
                        <p class="font-semibold">{{ ucfirst($selectedApproval->employment_type) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Join Date:</span>
                        <p class="font-semibold">{{ $selectedApproval->join_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Approver:</span>
                        <p class="font-semibold">{{ $selectedApproval->approver->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Requested By:</span>
                        <p class="font-semibold">{{ $selectedApproval->requestedBy->name }}</p>
                    </div>
                </div>

                @if($selectedApproval->benefits_package)
                <div class="border-t pt-4">
                    <span class="text-sm text-gray-600">Benefits Package:</span>
                    <p class="mt-1">{{ $selectedApproval->benefits_package }}</p>
                </div>
                @endif

                @if($selectedApproval->rejection_reason)
                <div class="border-t pt-4 bg-red-50 p-4 rounded">
                    <span class="text-sm text-red-600 font-semibold">Rejection Reason:</span>
                    <p class="mt-1 text-red-800">{{ $selectedApproval->rejection_reason }}</p>
                </div>
                @endif

                @if($selectedApproval->revision_notes)
                <div class="border-t pt-4 bg-orange-50 p-4 rounded">
                    <span class="text-sm text-orange-600 font-semibold">Revision Notes:</span>
                    <p class="mt-1 text-orange-800">{{ $selectedApproval->revision_notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
