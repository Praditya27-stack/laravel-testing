<div class="space-y-6">
    <!-- Application Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $application->job->vacancy_title ?? $application->job->title }}</h1>
                <p class="text-gray-600 mt-1">{{ $application->job->function ?? $application->job->department }}</p>
                <p class="text-sm text-gray-500 mt-2">Application ID: {{ $application->id }} | Applied on {{ $application->created_at->format('d M Y') }}</p>
            </div>
            <div>
                @if($application->current_stage === 'hired')
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold">✓ Hired</span>
                @elseif($application->current_stage === 'rejected')
                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-semibold">✗ Rejected</span>
                @else
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-semibold">In Progress</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-8">Application Progress</h2>
        
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
            
            <!-- Stages -->
            <div class="space-y-8">
                @foreach($stages as $index => $stage)
                <div class="relative flex items-start">
                    <!-- Icon -->
                    <div class="relative z-10 flex items-center justify-center w-16 h-16 rounded-full border-4 
                        @if($stage['status'] === 'completed') bg-green-500 border-green-200
                        @elseif($stage['status'] === 'current') bg-blue-500 border-blue-200 animate-pulse
                        @elseif($stage['status'] === 'rejected') bg-red-500 border-red-200
                        @else bg-gray-300 border-gray-200
                        @endif">
                        
                        @if($stage['status'] === 'completed')
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        @elseif($stage['status'] === 'current')
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($stage['status'] === 'rejected')
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="ml-6 flex-1">
                        <div class="bg-gray-50 rounded-lg p-6 
                            @if($stage['status'] === 'current') border-2 border-blue-500
                            @elseif($stage['status'] === 'completed') border-2 border-green-200
                            @elseif($stage['status'] === 'rejected') border-2 border-red-200
                            @else border-2 border-gray-200
                            @endif">
                            
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $stage['name'] }}</h3>
                                    
                                    @if($stage['status'] === 'completed')
                                        <p class="text-sm text-green-600 mt-1">✓ Completed</p>
                                    @elseif($stage['status'] === 'current')
                                        <p class="text-sm text-blue-600 mt-1">⏳ In Progress</p>
                                    @elseif($stage['status'] === 'rejected')
                                        <p class="text-sm text-red-600 mt-1">✗ Not Passed</p>
                                    @else
                                        <p class="text-sm text-gray-500 mt-1">⏸ Pending</p>
                                    @endif
                                </div>

                                @if($stage['started_at'])
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($stage['started_at'])->format('d M Y') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Stage Details -->
                            @if($stage['details'])
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    @if($stage['details']['type'] === 'psychotest')
                                        <div class="space-y-2 text-sm">
                                            <p><span class="font-medium">Test Date:</span> {{ \Carbon\Carbon::parse($stage['details']['date'])->format('d M Y') }} at {{ $stage['details']['time'] }}</p>
                                            <p><span class="font-medium">Status:</span> {{ ucfirst($stage['details']['status']) }}</p>
                                            @if(isset($stage['details']['score']))
                                                <p><span class="font-medium">Score:</span> {{ $stage['details']['score'] }}</p>
                                            @endif
                                        </div>
                                    @elseif($stage['details']['type'] === 'interview')
                                        <div class="space-y-2 text-sm">
                                            <p><span class="font-medium">Interview Date:</span> {{ \Carbon\Carbon::parse($stage['details']['date'])->format('d M Y') }} at {{ $stage['details']['time'] }}</p>
                                            <p><span class="font-medium">Location:</span> {{ $stage['details']['location'] }}</p>
                                            <p><span class="font-medium">Status:</span> {{ ucfirst($stage['details']['status']) }}</p>
                                        </div>
                                    @elseif($stage['details']['type'] === 'mcu')
                                        <div class="space-y-2 text-sm">
                                            <p><span class="font-medium">MCU Date:</span> {{ \Carbon\Carbon::parse($stage['details']['date'])->format('d M Y') }} at {{ $stage['details']['time'] }}</p>
                                            <p><span class="font-medium">Clinic:</span> {{ $stage['details']['clinic'] }}</p>
                                            <p><span class="font-medium">Status:</span> {{ ucfirst($stage['details']['status']) }}</p>
                                        </div>
                                    @elseif($stage['details']['type'] === 'offer')
                                        <div class="space-y-2 text-sm">
                                            <p><span class="font-medium">Offer Status:</span> {{ ucfirst($stage['details']['status']) }}</p>
                                            @if($stage['details']['sent_at'])
                                                <p><span class="font-medium">Sent:</span> {{ \Carbon\Carbon::parse($stage['details']['sent_at'])->format('d M Y') }}</p>
                                            @endif
                                            @if($stage['details']['status'] === 'sent')
                                                <a href="{{ route('offer.accept', ['token' => 'xxx']) }}" class="inline-block mt-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                                    View & Accept Offer
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            @if($stage['status'] === 'current')
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    @if($stage['key'] === 'psychotest' && $stage['details'])
                                        <p class="text-sm text-gray-600">Please check your email for psychotest invitation link.</p>
                                    @elseif($stage['key'] === 'hr_interview' || $stage['key'] === 'user_interview')
                                        <p class="text-sm text-gray-600">Interview schedule will be sent to your email.</p>
                                    @elseif($stage['key'] === 'background_check')
                                        <p class="text-sm text-gray-600">Please provide referee contacts when requested.</p>
                                    @elseif($stage['key'] === 'medical_checkup')
                                        <p class="text-sm text-gray-600">MCU schedule will be sent to your email.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div>
        <a href="{{ route('applicant.dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>
    </div>
</div>
