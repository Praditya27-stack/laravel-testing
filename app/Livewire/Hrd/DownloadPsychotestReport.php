<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\PsychotestResult;
use App\Models\Job;

class DownloadPsychotestReport extends Component
{
    // Filters for export
    public $exportJob;
    public $exportDateFrom;
    public $exportDateTo;
    public $exportResult;
    public $exportFormat = 'excel';
    public $includeDetails = true;

    public function mount()
    {
        // Set default date range (current month)
        $this->exportDateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->exportDateTo = now()->endOfMonth()->format('Y-m-d');
    }

    public function getJobs()
    {
        return Job::where('status', 'active')->get();
    }

    public function getPreviewData()
    {
        $query = PsychotestResult::with([
            'session.invitation.application.user',
            'session.invitation.application.applicantIdentity',
            'session.invitation.application.job'
        ]);

        // Apply filters
        if ($this->exportJob) {
            $query->whereHas('session.invitation.application', function($q) {
                $q->where('job_id', $this->exportJob);
            });
        }

        if ($this->exportDateFrom) {
            $query->whereDate('created_at', '>=', $this->exportDateFrom);
        }

        if ($this->exportDateTo) {
            $query->whereDate('created_at', '<=', $this->exportDateTo);
        }

        if ($this->exportResult) {
            $query->where('result', $this->exportResult);
        }

        return $query->orderBy('created_at', 'desc')->limit(10)->get();
    }

    public function getExportCount()
    {
        $query = PsychotestResult::query();

        if ($this->exportJob) {
            $query->whereHas('session.invitation.application', function($q) {
                $q->where('job_id', $this->exportJob);
            });
        }

        if ($this->exportDateFrom) {
            $query->whereDate('created_at', '>=', $this->exportDateFrom);
        }

        if ($this->exportDateTo) {
            $query->whereDate('created_at', '<=', $this->exportDateTo);
        }

        if ($this->exportResult) {
            $query->where('result', $this->exportResult);
        }

        return $query->count();
    }

    public function downloadExcel()
    {
        // TODO: Implement Excel export using Laravel Excel
        session()->flash('info', 'Excel export akan segera tersedia!');
    }

    public function downloadPDF()
    {
        // TODO: Implement PDF export using DomPDF or similar
        session()->flash('info', 'PDF export akan segera tersedia!');
    }

    public function downloadPsikogram($resultId)
    {
        // TODO: Generate Psikogram PDF for individual result
        session()->flash('info', 'Psikogram download akan segera tersedia!');
    }

    public function render()
    {
        $jobs = $this->getJobs();
        $previewData = $this->getPreviewData();
        $exportCount = $this->getExportCount();
        
        return view('livewire.hrd.download-psychotest-report', [
            'jobs' => $jobs,
            'previewData' => $previewData,
            'exportCount' => $exportCount,
        ])->layout('layouts.hrd');
    }
}
