<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use App\Models\OfferLetter;
use App\Models\OnboardingInfo;

class AcceptOfferLetter extends Component
{
    public $token;
    public $offer;
    public $application;
    public $decision = '';
    public $declineReason = '';
    public $acceptedTerms = false;
    public $signature = '';

    protected $rules = [
        'decision' => 'required|in:accept,decline',
        'declineReason' => 'required_if:decision,decline',
        'acceptedTerms' => 'required_if:decision,accept|accepted',
        'signature' => 'required_if:decision,accept',
    ];

    public function mount($token)
    {
        $this->token = $token;
        
        // TODO: Implement token-based offer retrieval
        // For now, find by offer_number or create token system
        $this->offer = OfferLetter::where('offer_number', $token)
            ->orWhere('id', $token)
            ->with(['application.user', 'application.job', 'approvalRequest'])
            ->firstOrFail();

        $this->application = $this->offer->application;

        // Check if already responded
        if ($this->offer->status !== 'sent') {
            session()->flash('error', 'This offer has already been responded to.');
        }
    }

    public function acceptOffer()
    {
        $this->decision = 'accept';
        
        $this->validate();

        $this->offer->markAsAccepted();

        // Create onboarding info
        $onboarding = new OnboardingInfo();
        $requiredDocs = $onboarding->getDefaultRequiredDocuments();

        OnboardingInfo::create([
            'application_id' => $this->application->id,
            'offer_letter_id' => $this->offer->id,
            'onboarding_date' => $this->offer->approvalRequest->briefing_date ?? $this->offer->approvalRequest->join_date,
            'onboarding_time' => '09:00',
            'onboarding_location' => 'PT Aisin Indonesia, Karawang',
            'required_documents' => $requiredDocs,
            'contact_person' => 'HRD Department: 0812-3456-7890',
            'status' => 'scheduled',
        ]);

        // TODO: Send confirmation email to HR
        // TODO: Send onboarding info to candidate

        session()->flash('message', '🎉 Congratulations! You have accepted the offer. Onboarding information will be sent to your email.');
        
        return redirect()->route('home');
    }

    public function declineOffer()
    {
        $this->decision = 'decline';
        
        $this->validate();

        $this->offer->markAsDeclined($this->declineReason);

        // TODO: Send notification to HR

        session()->flash('message', 'Thank you for your response. We wish you the best in your career.');
        
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.applicant.accept-offer-letter')->layout('layouts.landing');
    }
}
