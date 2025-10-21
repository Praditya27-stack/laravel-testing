<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Recruitment Process</h1>
                <p class="text-gray-600 mt-2">{{ $job->vacancy_title }} - {{ $job->code }}</p>
            </div>
            <a href="{{ route('hrd.jobs.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                ← Back to Jobs
            </a>
        </div>
    </div>

    <!-- Job Info Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-gray-500">Position</p>
                <p class="font-semibold text-gray-900">{{ $job->position }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Education</p>
                <p class="font-semibold text-gray-900">{{ $job->education_level }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Applicants</p>
                <p class="font-semibold text-blue-600 text-xl">{{ $job->applications->count() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Selection Type</p>
                <p class="font-semibold text-gray-900">
                    {{ $job->selection_type === 'operator_smk' ? 'Operator SMK (6 stages)' : 'Staff D3/S1 (7 stages)' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Stages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($stages as $index => $stage)
            @if($stage['total'] > 0 || $index === 0)
                <a href="{{ route('hrd.recruitment.stage', ['job_id' => $job_id, 'stage' => $stage['name']]) }}" 
                    class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 {{ $stage['in_progress'] > 0 ? 'border-blue-600' : ($stage['passed'] > 0 ? 'border-green-600' : 'border-gray-300') }}">
                    
                    <!-- Stage Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                    Stage {{ $index + 1 }}
                                </span>
                                @if($stage['in_progress'] > 0)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                                        Active
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $stage['label'] }}</h3>
                        </div>
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>

                    <!-- Statistics -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Candidates</span>
                            <span class="font-semibold text-gray-900">{{ $stage['total'] }}</span>
                        </div>
                        
                        @if($stage['in_progress'] > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">In Progress</span>
                                <span class="font-semibold text-blue-600">{{ $stage['in_progress'] }}</span>
                            </div>
                        @endif

                        @if($stage['passed'] > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Passed</span>
                                <span class="font-semibold text-green-600">{{ $stage['passed'] }}</span>
                            </div>
                        @endif

                        @if($stage['failed'] > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Failed</span>
                                <span class="font-semibold text-red-600">{{ $stage['failed'] }}</span>
                            </div>
                        @endif

                        @if($stage['pending'] > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Pending</span>
                                <span class="font-semibold text-gray-600">{{ $stage['pending'] }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Progress Bar -->
                    @if($stage['total'] > 0)
                        <div class="mt-4">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>{{ round(($stage['passed'] + $stage['failed']) / $stage['total'] * 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ round(($stage['passed'] + $stage['failed']) / $stage['total'] * 100) }}%"></div>
                            </div>
                        </div>
                    @endif
                </a>
            @endif
        @endforeach
    </div>

    <!-- Empty State -->
    @if($job->applications->count() === 0)
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Applications Yet</h3>
            <p class="text-gray-600">There are no applications for this job vacancy yet.</p>
        </div>
    @endif
</div>
