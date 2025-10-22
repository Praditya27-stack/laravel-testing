<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Psychotest Report & Scoring</h1>
            <p class="mt-1 text-sm text-gray-600">View and score psychotest results</p>
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
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Passed</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['passed'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-red-600">Failed</div>
            <div class="mt-2 text-3xl font-bold text-red-900">{{ $statistics['failed'] }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-yellow-600">Pending</div>
            <div class="mt-2 text-3xl font-bold text-yellow-900">{{ $statistics['pending'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-blue-600">Avg Score</div>
            <div class="mt-2 text-3xl font-bold text-blue-900">{{ $statistics['avg_score'] }}</div>
        </div>
        <div class="bg-purple-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-purple-600">Pass Rate</div>
            <div class="mt-2 text-3xl font-bold text-purple-900">{{ $statistics['pass_rate'] }}%</div>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Result</label>
                <select wire:model.live="filterResult" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Results</option>
                    <option value="passed">Passed</option>
                    <option value="failed">Failed</option>
                    <option value="pending">Pending</option>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($results as $result)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $result->session->invitation->application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $result->session->invitation->application->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $result->session->invitation->application->job->vacancy_title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            {{ strtoupper($result->test_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-lg font-bold text-gray-900">{{ $result->total_score ?? '-' }}</div>
                        <div class="text-xs text-gray-500">Score: {{ $result->score ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($result->result === 'passed')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Passed</span>
                        @elseif($result->result === 'failed')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Failed</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button wire:click="viewDetail({{ $result->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                        @if($result->result === 'pending')
                            <button wire:click="openScoreModal({{ $result->session_id }})" class="text-green-600 hover:text-green-900">Score</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No psychotest results found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t">
            {{ $results->links() }}
        </div>
    </div>

    <!-- Score Modal -->
    @if($showScoreModal && $selectedSession)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-8 border w-full max-w-3xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Score Psychotest</h3>
                <button wire:click="$set('showScoreModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form wire:submit.prevent="saveScores">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Candidate: <span class="font-semibold">{{ $selectedSession->invitation->application->user->name }}</span></p>
                        <p class="text-sm text-gray-600">Test Type: <span class="font-semibold">{{ strtoupper($selectedSession->invitation->test_type) }}</span></p>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-4">Test Scores (0-100)</h4>
                        <div class="grid grid-cols-2 gap-4">
                            @if($selectedSession->invitation->test_type === 'smk')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">WPT</label>
                                    <input type="number" wire:model.live="scores.wpt" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Army Alpha</label>
                                    <input type="number" wire:model.live="scores.army_alpha" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Papikostick</label>
                                    <input type="number" wire:model.live="scores.papikostick" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">SSCT</label>
                                    <input type="number" wire:model.live="scores.ssct" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kraeplin</label>
                                    <input type="number" wire:model.live="scores.kraeplin" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                            @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Inteligensi</label>
                                    <input type="number" wire:model.live="scores.inteligensi" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kepribadian</label>
                                    <input type="number" wire:model.live="scores.kepribadian" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Perilaku Kerja</label>
                                    <input type="number" wire:model.live="scores.perilaku_kerja" min="0" max="100" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Total Score: <span class="text-2xl font-bold text-blue-900">{{ $totalScore }}</span></p>
                            <p class="text-sm text-gray-600">Passing Grade: <span class="font-semibold">{{ $selectedSession->invitation->passing_grade }}</span></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Result</label>
                        <select wire:model="result" class="w-full px-4 py-2 border rounded-lg">
                            <option value="passed">Passed</option>
                            <option value="failed">Failed</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea wire:model="notes" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="$set('showScoreModal', false)" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Score
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
