<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">My Applications</h1>
        
        <div class="space-y-4">
            @forelse($applications as $app)
            <div class="border rounded-lg p-6 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $app->job->vacancy_title ?? $app->job->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $app->job->function ?? $app->job->department }}</p>
                        <p class="text-xs text-gray-500 mt-2">Applied {{ $app->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="ml-4 flex flex-col items-end gap-2">
                        @if($app->current_stage === 'hired')
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">✓ Hired</span>
                        @elseif($app->current_stage === 'rejected')
                            <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-semibold">✗ Rejected</span>
                        @else
                            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ ucfirst(str_replace('_', ' ', $app->current_stage)) }}</span>
                        @endif
                        <a href="{{ route('applicant.application', $app->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View Progress →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-600 font-semibold">No applications yet</p>
                <p class="text-sm text-gray-500 mt-2">Start by browsing available job opportunities</p>
                <a href="{{ route('jobs.index') }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Browse Jobs
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
