<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Download Psychotest Report</h1>
            <p class="mt-1 text-sm text-gray-600">Export psychotest results to Excel or PDF</p>
        </div>
        <a href="{{ route('hrd.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Export Configuration -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Export Configuration</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Filters -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700">Filters</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Position</label>
                    <select wire:model.live="exportJob" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Jobs</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->vacancy_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                        <input type="date" wire:model.live="exportDateFrom" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                        <input type="date" wire:model.live="exportDateTo" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Result</label>
                    <select wire:model.live="exportResult" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Results</option>
                        <option value="passed">Passed Only</option>
                        <option value="failed">Failed Only</option>
                        <option value="pending">Pending Only</option>
                    </select>
                </div>
            </div>

            <!-- Export Options -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700">Export Options</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model="exportFormat" value="excel" class="mr-2">
                            <span>Excel (.xlsx)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="exportFormat" value="pdf" class="mr-2">
                            <span>PDF (.pdf)</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="includeDetails" class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Include Detailed Scores</span>
                    </label>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Records to export:</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $exportCount }}</p>
                </div>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="mt-6 flex space-x-4">
            @if($exportFormat === 'excel')
                <button wire:click="downloadExcel" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Excel
                </button>
            @else
                <button wire:click="downloadPDF" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </button>
            @endif
        </div>
    </div>

    <!-- Preview Data -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Preview Data (First 10 records)</h3>
        </div>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($previewData as $result)
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
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $result->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <button wire:click="downloadPsikogram({{ $result->id }})" class="text-blue-600 hover:text-blue-900 text-sm">
                            Download Psikogram
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        No data to preview. Adjust your filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Info Box -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Note:</strong> Excel and PDF export functionality will be available soon. Individual Psikogram download is also coming soon.
                </p>
            </div>
        </div>
    </div>
</div>
