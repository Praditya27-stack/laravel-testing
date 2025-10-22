<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Application;
use App\Models\OfferLetter;
use App\Models\OnboardingInfo;
use App\Models\HiredExportLog;

class HiredCandidates extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    
    // Export
    public $showExportModal = false;
    public $exportType = 'excel';
    public $dateFrom;
    public $dateTo;
    
    // Onboarding Modal
    public $showOnboardingModal = false;
    public $selectedApplication = null;
    public $onboarding_date;
    public $onboarding_time;
    public $onboarding_location = 'PT Aisin Indonesia, Karawang';
    public $contact_person = 'HRD Department: 0812-3456-7890';

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function openOnboardingModal($applicationId)
    {
        $this->selectedApplication = Application::with(['user', 'offerLetter'])->find($applicationId);
        $this->showOnboardingModal = true;
    }

    public function sendOnboardingInfo()
    {
        $this->validate([
            'onboarding_date' => 'required|date',
            'onboarding_time' => 'required',
            'onboarding_location' => 'required|string',
            'contact_person' => 'required|string',
        ]);

        $onboarding = new OnboardingInfo();
        $requiredDocs = $onboarding->getDefaultRequiredDocuments();

        OnboardingInfo::create([
            'application_id' => $this->selectedApplication->id,
            'offer_letter_id' => $this->selectedApplication->offerLetter->id,
            'onboarding_date' => $this->onboarding_date,
            'onboarding_time' => $this->onboarding_time,
            'onboarding_location' => $this->onboarding_location,
            'required_documents' => $requiredDocs,
            'contact_person' => $this->contact_person,
            'status' => 'sent',
            'info_sent_at' => now(),
        ]);

        // TODO: Send onboarding email

        session()->flash('message', '✅ Onboarding information sent successfully!');
        
        $this->showOnboardingModal = false;
        $this->reset(['selectedApplication', 'onboarding_date', 'onboarding_time']);
    }

    public function markAsOnboarded($applicationId)
    {
        $application = Application::find($applicationId);
        
        if ($application && $application->onboardingInfo) {
            $application->onboardingInfo->markAsCompleted();
            $application->onboardingInfo->archive();
            
            session()->flash('message', '✅ Candidate marked as onboarded!');
        }
    }

    public function exportData()
    {
        $this->validate([
            'exportType' => 'required|in:excel,realta',
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date|after_or_equal:dateFrom',
        ]);

        $applications = Application::with(['user', 'job', 'offerLetter', 'hiringApprovalRequest'])
            ->where('current_stage', 'hired')
            ->whereHas('offerLetter', function($q) {
                $q->where('status', 'accepted')
                  ->whereBetween('accepted_at', [$this->dateFrom, $this->dateTo]);
            })
            ->get();

        // TODO: Generate Excel file based on export type
        
        HiredExportLog::create([
            'export_type' => $this->exportType,
            'file_path' => 'exports/hired_' . now()->format('YmdHis') . '.xlsx',
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'total_records' => $applications->count(),
            'exported_by' => auth()->id(),
        ]);

        session()->flash('message', "✅ Exported {$applications->count()} records successfully!");
        
        $this->showExportModal = false;
    }

    public function getHiredCandidatesProperty()
    {
        $query = Application::with(['user', 'job', 'offerLetter', 'onboardingInfo'])
            ->where('current_stage', 'hired')
            ->whereHas('offerLetter', function($q) {
                $q->where('status', 'accepted');
            });

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'onboarded') {
            $query->whereHas('onboardingInfo', function($q) {
                $q->where('status', 'completed');
            });
        } elseif ($this->filterStatus === 'pending_onboarding') {
            $query->whereDoesntHave('onboardingInfo');
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.hrd.hired-candidates', [
            'hiredCandidates' => $this->hiredCandidates,
        ])->layout('layouts.hrd');
    }
}
