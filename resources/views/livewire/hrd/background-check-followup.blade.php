<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Background Check Follow-up</h1>
            <p class="mt-1 text-sm text-gray-600">Manage pending forms and send reminders</p>
        </div>
        <a href="{{ route('hrd.background-check.results') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Results
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search candidate or referee..." 
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter By</label>
                <select wire:model.live="filterDays" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Pending</option>
                    <option value="sent_3_days">Sent > 3 days ago</option>
                    <option value="expiring_2_days">Expiring in 2 days</option>
                    <option value="reminded_3_times">Reminded ≥ 3 times</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Pending Requests Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sent Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reminders</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pendingRequests as $request)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $request->application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $request->application->job->vacancy_title ?? $request->application->job->title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $request->referee->name }}</div>
                        <div class="text-sm text-gray-500">{{ $request->referee->email }}</div>
                        <div class="text-sm text-gray-500">{{ $request->referee->phone }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $request->sent_at?->format('d M Y') ?? '-' }}
                        @if($request->sent_at)
                            <div class="text-xs text-gray-500">{{ $request->sent_at->diffForHumans() }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $daysLeft = $request->link_expiry_date->diffInDays(now(), false);
                        @endphp
                        <div class="text-sm font-medium {{ $daysLeft > -3 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $request->link_expiry_date->format('d M Y') }}
                        </div>
                        <div class="text-xs {{ $daysLeft > -3 ? 'text-red-500' : 'text-gray-500' }}">
                            {{ $request->link_expiry_date->diffForHumans() }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $request->reminder_count >= 3 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $request->reminder_count }}x
                        </span>
                        @if($request->last_reminder_at)
                            <div class="text-xs text-gray-500 mt-1">Last: {{ $request->last_reminder_at->format('d M') }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col space-y-1">
                            <button wire:click="sendReminder({{ $request->id }})" class="text-blue-600 hover:text-blue-900 text-sm">
                                📧 Send Reminder
                            </button>
                            <button wire:click="openExtendModal({{ $request->id }})" class="text-green-600 hover:text-green-900 text-sm">
                                ⏰ Extend Expiry
                            </button>
                            <button wire:click="openPhoneCallModal({{ $request->id }})" class="text-purple-600 hover:text-purple-900 text-sm">
                                📞 Log Phone Call
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold">No pending requests found</p>
                        <p class="text-sm">All background check forms have been completed!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t">
            {{ $pendingRequests->links() }}
        </div>
    </div>

    <!-- Extend Expiry Modal -->
    @if($showExtendModal && $selectedRequest)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Extend Link Expiry</h3>
                <button wire:click="$set('showExtendModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form wire:submit.prevent="extendExpiry">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Candidate: <span class="font-semibold">{{ $selectedRequest->application->user->name }}</span></p>
                        <p class="text-sm text-gray-600">Referee: <span class="font-semibold">{{ $selectedRequest->referee->name }}</span></p>
                        <p class="text-sm text-gray-600">Current Expiry: <span class="font-semibold">{{ $selectedRequest->link_expiry_date->format('d M Y') }}</span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Extend By (Days)</label>
                        <input type="number" wire:model="extendDays" min="1" max="30" class="w-full px-4 py-2 border rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">New expiry: {{ $selectedRequest->link_expiry_date->addDays($extendDays)->format('d M Y') }}</p>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="$set('showExtendModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Extend Expiry
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Phone Call Modal -->
    @if($showPhoneCallModal && $selectedRequest)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Log Phone Call</h3>
                <button wire:click="$set('showPhoneCallModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form wire:submit.prevent="logPhoneCall">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Referee: <span class="font-semibold">{{ $selectedRequest->referee->name }}</span></p>
                        <p class="text-sm text-gray-600">Phone: <span class="font-semibold">{{ $selectedRequest->referee->phone }}</span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Call Notes</label>
                        <textarea wire:model="phoneCallNotes" rows="4" class="w-full px-4 py-2 border rounded-lg" placeholder="Describe the phone call outcome..."></textarea>
                        @error('phoneCallNotes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="$set('showPhoneCallModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Save Log
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Info Box -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Follow-up Tips</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Send first reminder after 3 days of no response</li>
                        <li>Maximum 3 reminders before considering phone call</li>
                        <li>Extend expiry if referee needs more time</li>
                        <li>Always log phone call outcomes for record keeping</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
