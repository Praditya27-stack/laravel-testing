<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MedicalCheckupSchedule;
use App\Models\MedicalCheckupResult;
use App\Models\McuClinic;
use App\Models\Job;

class MedicalCheckupStatus extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterResult = '';
    public $filterJob = '';
    public $filterImportMethod = '';
    
    // Statistics
    public $statistics = [];
    
    // Detail Modal
    public $showDetailModal = false;
    public $selectedResult = null;

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $totalScheduled = MedicalCheckupSchedule::count();
        $scheduled = MedicalCheckupSchedule::where('status', 'scheduled')->count();
        $completed = MedicalCheckupSchedule::where('status', 'completed')->count();
        $noShow = MedicalCheckupSchedule::where('status', 'no_show')->count();
        
        $totalResults = MedicalCheckupResult::count();
        $fit = MedicalCheckupResult::where('result', 'fit')->count();
        $unfit = MedicalCheckupResult::where('result', 'unfit')->count();
        $pending = MedicalCheckupResult::where('result', 'pending')->count();
        $needRetest = MedicalCheckupResult::where('result', 'need_retest')->count();
        
        $manualInput = MedicalCheckupResult::where('import_method', 'manual')->count();
        $excelImport = MedicalCheckupResult::where('import_method', 'excel')->count();
        
        $passRate = $totalResults > 0 ? round(($fit / $totalResults) * 100, 1) : 0;

        $this->statistics = [
            'total_scheduled' => $totalScheduled,
            'scheduled' => $scheduled,
            'completed' => $completed,
            'no_show' => $noShow,
            'total_results' => $totalResults,
            'fit' => $fit,
            'unfit' => $unfit,
            'pending' => $pending,
            'need_retest' => $needRetest,
            'manual_input' => $manualInput,
            'excel_import' => $excelImport,
            'pass_rate' => $passRate,
        ];
    }

    public function viewDetail($resultId)
    {
        $this->selectedResult = MedicalCheckupResult::with([
            'application.user',
            'application.job',
            'schedule.clinic',
            'assessedBy'
        ])->find($resultId);
        
        $this->showDetailModal = true;
    }

    public function downloadPDF($resultId)
    {
        // TODO: Generate PDF report
        session()->flash('info', 'PDF download coming soon!');
    }

    public function resendInvitation($scheduleId)
    {
        $schedule = MedicalCheckupSchedule::find($scheduleId);
        
        if ($schedule) {
            $schedule->sendReminder();
            session()->flash('message', '✅ Invitation resent successfully!');
        }
    }

    public function getResultsProperty()
    {
        $query = MedicalCheckupResult::with([
            'application.user',
            'application.job',
            'schedule.clinic',
            'assessedBy'
        ]);

        if ($this->search) {
            $query->whereHas('application.user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterResult) {
            $query->where('result', $this->filterResult);
        }

        if ($this->filterJob) {
            $query->whereHas('application', function ($q) {
                $q->where('job_id', $this->filterJob);
            });
        }

        if ($this->filterImportMethod) {
            $query->where('import_method', $this->filterImportMethod);
        }

        return $query->latest()->paginate(10);
    }

    public function getJobsProperty()
    {
        return Job::where('status', 'open')->get();
    }

    public function render()
    {
        return view('livewire.hrd.medical-checkup-status', [
            'results' => $this->results,
            'jobs' => $this->jobs,
        ])->layout('layouts.hrd');
    }
}
