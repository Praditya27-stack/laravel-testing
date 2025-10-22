<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Medical Checkup Status</h1>
            <p class="mt-1 text-sm text-gray-600">View and manage MCU results</p>
        </div>
        <a href="{{ route('hrd.medical-checkup.schedule') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Schedule New MCU
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm font-medium text-gray-600">Total Scheduled</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['total_scheduled'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-blue-600">Scheduled</div>
            <div class="mt-2 text-3xl font-bold text-blue-900">{{ $statistics['scheduled'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Completed</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['completed'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-red-600">No Show</div>
            <div class="mt-2 text-3xl font-bold text-red-900">{{ $statistics['no_show'] }}</div>
        </div>
        <div class="bg-purple-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-purple-600">Pass Rate</div>
            <div class="mt-2 text-3xl font-bold text-purple-900">{{ $statistics['pass_rate'] }}%</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-yellow-600">Pending</div>
            <div class="mt-2 text-3xl font-bold text-yellow-900">{{ $statistics['pending'] }}</div>
        </div>
    </div>

    <!-- Result Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-green-600">Fit</div>
            <div class="mt-2 text-3xl font-bold text-green-900">{{ $statistics['fit'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-red-600">Unfit</div>
            <div class="mt-2 text-3xl font-bold text-red-900">{{ $statistics['unfit'] }}</div>
        </div>
        <div class="bg-orange-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-orange-600">Need Retest</div>
            <div class="mt-2 text-3xl font-bold text-orange-900">{{ $statistics['need_retest'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-blue-600">Manual Input</div>
            <div class="mt-2 text-3xl font-bold text-blue-900">{{ $statistics['manual_input'] }}</div>
        </div>
        <div class="bg-indigo-50 rounded-lg shadow p-6">
            <div class="text-sm font-medium text-indigo-600">Excel Import</div>
            <div class="mt-2 text-3xl font-bold text-indigo-900">{{ $statistics['excel_import'] }}</div>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Result</label>
                <select wire:model.live="filterResult" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Results</option>
                    <option value="fit">Fit</option>
                    <option value="unfit">Unfit</option>
                    <option value="pending">Pending</option>
                    <option value="need_retest">Need Retest</option>
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Import Method</label>
                <select wire:model.live="filterImportMethod" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Methods</option>
                    <option value="manual">Manual Input</option>
                    <option value="excel">Excel Import</option>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">MCU Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clinic</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Overall Fitness</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($results as $result)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $result->application->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $result->application->job->vacancy_title ?? $result->application->job->title }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($result->schedule)
                            {{ $result->schedule->mcu_date->format('d M Y') }}
                            <div class="text-xs text-gray-500">{{ $result->schedule->mcu_time }}</div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $result->schedule?->clinic?->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($result->overall_fitness === 'fit')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Fit</span>
                        @elseif($result->overall_fitness === 'unfit')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Unfit</span>
                        @elseif($result->overall_fitness === 'need_retest')
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Need Retest</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($result->result === 'fit')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">✓ Passed</span>
                        @elseif($result->result === 'unfit')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">✗ Failed</span>
                        @elseif($result->result === 'need_retest')
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">⏳ Retest</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button wire:click="viewDetail({{ $result->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                        <a href="{{ route('hrd.medical-checkup.input', $result->application_id) }}" class="text-green-600 hover:text-green-900">Edit</a>
                        <button wire:click="downloadPDF({{ $result->id }})" class="text-purple-600 hover:text-purple-900">PDF</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No MCU results found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t">
            {{ $results->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedResult)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">MCU Result Details</h3>
                <button wire:click="$set('showDetailModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Candidate Info -->
                <div class="border-b pb-4">
                    <h4 class="font-semibold mb-2">Candidate Information</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Name:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->application->user->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Position:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->application->job->vacancy_title ?? $selectedResult->application->job->title }}</span>
                        </div>
                    </div>
                </div>

                <!-- Vital Signs -->
                <div class="border-b pb-4">
                    <h4 class="font-semibold mb-2">Vital Signs</h4>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Blood Pressure:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->blood_pressure ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Heart Rate:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->heart_rate ?? '-' }} BPM</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Temperature:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->body_temperature ?? '-' }}°C</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Height:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->height ?? '-' }} cm</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Weight:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->weight ?? '-' }} kg</span>
                        </div>
                        <div>
                            <span class="text-gray-600">BMI:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->bmi ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Vision & Hearing -->
                <div class="border-b pb-4">
                    <h4 class="font-semibold mb-2">Vision & Hearing</h4>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Vision Left:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->vision_left ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Vision Right:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->vision_right ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Hearing:</span>
                            <span class="font-semibold ml-2">{{ ucfirst($selectedResult->hearing_test ?? '-') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Lab Tests -->
                @if($selectedResult->blood_test_results || $selectedResult->urine_test_results || $selectedResult->xray_result)
                <div class="border-b pb-4">
                    <h4 class="font-semibold mb-2">Laboratory Tests</h4>
                    <div class="space-y-2 text-sm">
                        @if($selectedResult->blood_test_results)
                        <div>
                            <span class="text-gray-600">Blood Test:</span>
                            <p class="mt-1">{{ $selectedResult->blood_test_results }}</p>
                        </div>
                        @endif
                        @if($selectedResult->urine_test_results)
                        <div>
                            <span class="text-gray-600">Urine Test:</span>
                            <p class="mt-1">{{ $selectedResult->urine_test_results }}</p>
                        </div>
                        @endif
                        @if($selectedResult->xray_result)
                        <div>
                            <span class="text-gray-600">X-Ray:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->xray_result }}</span>
                            @if($selectedResult->xray_notes)
                                <p class="text-xs text-gray-500 mt-1">{{ $selectedResult->xray_notes }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Final Result -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-2">Final Assessment</h4>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="text-gray-600">Overall Fitness:</span>
                            <span class="font-semibold ml-2">{{ ucfirst(str_replace('_', ' ', $selectedResult->overall_fitness)) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Result:</span>
                            <span class="font-semibold ml-2">{{ ucfirst(str_replace('_', ' ', $selectedResult->result)) }}</span>
                        </div>
                        @if($selectedResult->medical_notes)
                        <div>
                            <span class="text-gray-600">Medical Notes:</span>
                            <p class="mt-1">{{ $selectedResult->medical_notes }}</p>
                        </div>
                        @endif
                        @if($selectedResult->unfit_reason)
                        <div>
                            <span class="text-gray-600">Unfit Reason:</span>
                            <p class="mt-1 text-red-600">{{ $selectedResult->unfit_reason }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="text-gray-600">Assessed By:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->assessedBy?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Assessed At:</span>
                            <span class="font-semibold ml-2">{{ $selectedResult->assessed_at?->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
