<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">PT Aisin Indonesia</h1>
            <p class="mt-2 text-lg text-gray-600">Background Check Reference Form</p>
        </div>

        @if(!$isValid)
            <!-- Invalid Token -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Invalid Link</h2>
                <p class="text-gray-600">This background check form link is invalid or has been removed.</p>
            </div>

        @elseif($isExpired)
            <!-- Expired Link -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Link Expired</h2>
                <p class="text-gray-600 mb-4">This background check form link has expired.</p>
                <p class="text-sm text-gray-500">Please contact PT Aisin Indonesia HR Department for a new link.</p>
            </div>

        @elseif($isCompleted)
            <!-- Already Completed -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Already Submitted</h2>
                <p class="text-gray-600">This form has already been completed. Thank you for your response!</p>
            </div>

        @elseif($submitted)
            <!-- Success Message -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Thank You!</h2>
                <p class="text-gray-600 mb-4">Your response has been submitted successfully.</p>
                <p class="text-sm text-gray-500">We appreciate your time and cooperation in this background check process.</p>
            </div>

        @else
            <!-- Form Introduction -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Reference Check Request</h2>
                <div class="space-y-3 text-gray-700">
                    <p>Dear <strong>{{ $request->referee->name }}</strong>,</p>
                    <p>We are conducting a background check for <strong>{{ $request->application->user->name }}</strong> who has applied for the position of <strong>{{ $request->application->job->vacancy_title ?? $request->application->job->title }}</strong> at PT Aisin Indonesia.</p>
                    <p>As a reference provided by the candidate, we would greatly appreciate if you could complete this brief questionnaire about their work performance and character.</p>
                    <p class="text-sm text-gray-600">This form will take approximately 5-10 minutes to complete. All information provided will be kept confidential.</p>
                </div>
            </div>

            <!-- The Form -->
            <form wire:submit.prevent="submitForm" class="bg-white rounded-lg shadow-lg p-8">
                <div class="space-y-6">
                    <!-- Duration Known -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            1. How long have you known the candidate? <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="duration_known" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 2 years, 6 months">
                        @error('duration_known') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Rating Questions -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Please rate the candidate on the following criteria (1 = Poor, 5 = Excellent)</h3>
                        
                        @php
                            $ratings = [
                                ['field' => 'rating_work_performance', 'label' => '2. Work Performance'],
                                ['field' => 'rating_attendance', 'label' => '3. Attendance & Punctuality'],
                                ['field' => 'rating_teamwork', 'label' => '4. Teamwork & Collaboration'],
                                ['field' => 'rating_integrity', 'label' => '5. Integrity & Ethics'],
                                ['field' => 'rating_communication', 'label' => '6. Communication Skills'],
                                ['field' => 'rating_problem_solving', 'label' => '7. Problem Solving Ability'],
                            ];
                        @endphp

                        @foreach($ratings as $rating)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $rating['label'] }} <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-4">
                                @for($i = 1; $i <= 5; $i++)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" wire:model="{{ $rating['field'] }}" value="{{ $i }}" class="mr-2">
                                    <span class="text-sm">{{ $i }}</span>
                                </label>
                                @endfor
                            </div>
                            @error($rating['field']) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        @endforeach
                    </div>

                    <!-- Would Recommend -->
                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            8. Would you recommend this candidate for employment? <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="would_recommend" value="yes" class="mr-2">
                                <span>Yes, I would recommend</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="would_recommend" value="maybe" class="mr-2">
                                <span>Maybe, with reservations</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="would_recommend" value="no" class="mr-2">
                                <span>No, I would not recommend</span>
                            </label>
                        </div>
                        @error('would_recommend') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Reason for Leaving -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            9. What was the reason for the candidate leaving your organization? <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="reason_for_leaving" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Please provide details..."></textarea>
                        @error('reason_for_leaving') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Additional Comments -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            10. Additional Comments (Optional)
                        </label>
                        <textarea wire:model="additional_comments" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Any other information you would like to share about the candidate..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="border-t pt-6">
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Submit Response
                        </button>
                    </div>

                    <p class="text-xs text-gray-500 text-center">
                        By submitting this form, you confirm that all information provided is accurate to the best of your knowledge.
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} PT Aisin Indonesia. All rights reserved.</p>
                <p class="mt-1">For questions, please contact: hr@aisin.co.id</p>
            </div>
        @endif
    </div>
</div>
