<div class="max-w-4xl mx-auto space-y-6">
    @if(session()->has('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <p class="text-red-800">{{ session('error') }}</p>
    </div>
    @endif

    @if($offer->status === 'sent')
    <!-- Offer Letter Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-lg shadow-lg p-8 text-white">
        <h1 class="text-3xl font-bold">🎉 Congratulations!</h1>
        <p class="mt-2 text-green-100">You have received a job offer from PT Aisin Indonesia</p>
    </div>

    <!-- Offer Details -->
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Offer Letter Details</h2>
        
        <div class="prose max-w-none">
            {!! $offer->offer_letter_content !!}
        </div>

        <!-- Key Details Summary -->
        <div class="mt-8 grid grid-cols-2 gap-6 p-6 bg-gray-50 rounded-lg">
            <div>
                <p class="text-sm text-gray-600">Position</p>
                <p class="font-semibold text-gray-900">{{ $offer->approvalRequest->position_title }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Department</p>
                <p class="font-semibold text-gray-900">{{ $offer->approvalRequest->department }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Salary</p>
                <p class="font-semibold text-gray-900">Rp {{ number_format($offer->approvalRequest->salary_offered, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Employment Type</p>
                <p class="font-semibold text-gray-900">{{ ucfirst($offer->approvalRequest->employment_type) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Join Date</p>
                <p class="font-semibold text-gray-900">{{ $offer->approvalRequest->join_date->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Response Deadline</p>
                <p class="font-semibold text-red-600">{{ $offer->response_deadline->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="bg-white rounded-lg shadow p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Terms & Conditions</h3>
        <div class="space-y-3 text-sm text-gray-700">
            <p>✓ This offer is contingent upon successful completion of all pre-employment requirements.</p>
            <p>✓ You are required to submit all necessary documents before your start date.</p>
            <p>✓ Employment is subject to a probationary period as per company policy.</p>
            <p>✓ You agree to abide by all company policies and procedures.</p>
            <p>✓ This offer is confidential and should not be shared with unauthorized parties.</p>
        </div>
    </div>

    <!-- Decision Form -->
    <div class="bg-white rounded-lg shadow p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Your Response</h3>
        
        <!-- Accept Section -->
        <div class="mb-8 p-6 border-2 border-green-200 rounded-lg hover:border-green-400 transition">
            <div class="flex items-start">
                <input type="radio" wire:model="decision" value="accept" id="accept" class="mt-1 mr-4">
                <label for="accept" class="flex-1 cursor-pointer">
                    <h4 class="text-lg font-semibold text-green-700">✓ I Accept This Offer</h4>
                    <p class="text-sm text-gray-600 mt-1">I am excited to join PT Aisin Indonesia and accept all terms and conditions.</p>
                </label>
            </div>

            @if($decision === 'accept')
            <div class="mt-6 space-y-4 pl-8">
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" wire:model="acceptedTerms" class="mt-1 mr-3">
                        <span class="text-sm text-gray-700">
                            I have read and agree to all terms and conditions stated in this offer letter. <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('acceptedTerms') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Digital Signature (Type your full name) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="signature" placeholder="Type your full name" 
                        class="w-full px-4 py-2 border rounded-lg font-signature text-2xl">
                    @error('signature') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500 mt-1">This will serve as your digital signature</p>
                </div>

                <button wire:click="acceptOffer" 
                    class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                    ✓ Confirm Acceptance
                </button>
            </div>
            @endif
        </div>

        <!-- Decline Section -->
        <div class="p-6 border-2 border-red-200 rounded-lg hover:border-red-400 transition">
            <div class="flex items-start">
                <input type="radio" wire:model="decision" value="decline" id="decline" class="mt-1 mr-4">
                <label for="decline" class="flex-1 cursor-pointer">
                    <h4 class="text-lg font-semibold text-red-700">✗ I Decline This Offer</h4>
                    <p class="text-sm text-gray-600 mt-1">I appreciate the offer but must respectfully decline at this time.</p>
                </label>
            </div>

            @if($decision === 'decline')
            <div class="mt-6 space-y-4 pl-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Declining <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="declineReason" rows="4" 
                        class="w-full px-4 py-2 border rounded-lg" 
                        placeholder="Please share your reason (optional but appreciated)"></textarea>
                    @error('declineReason') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <button wire:click="declineOffer" 
                    class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                    ✗ Confirm Decline
                </button>
            </div>
            @endif
        </div>

        @error('decision') <p class="text-sm text-red-600 mt-4">{{ $message }}</p> @enderror
    </div>

    <!-- Help Section -->
    <div class="bg-blue-50 rounded-lg p-6">
        <h4 class="font-semibold text-blue-900 mb-2">Need Help?</h4>
        <p class="text-sm text-blue-800">
            If you have any questions about this offer, please contact our HR Department at 
            <a href="mailto:recruitment@aisin.co.id" class="underline">recruitment@aisin.co.id</a> or 
            call <a href="tel:+6281234567890" class="underline">0812-3456-7890</a>
        </p>
    </div>

    @else
    <!-- Already Responded -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        @if($offer->status === 'accepted')
        <div class="text-green-600 mb-4">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Offer Accepted!</h2>
        <p class="text-gray-600">You accepted this offer on {{ $offer->accepted_at->format('d F Y') }}</p>
        <p class="text-sm text-gray-500 mt-4">Onboarding information has been sent to your email.</p>
        @elseif($offer->status === 'declined')
        <div class="text-red-600 mb-4">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Offer Declined</h2>
        <p class="text-gray-600">You declined this offer on {{ $offer->declined_at->format('d F Y') }}</p>
        @endif

        <a href="{{ route('applicant.dashboard') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Go to Dashboard
        </a>
    </div>
    @endif
</div>
