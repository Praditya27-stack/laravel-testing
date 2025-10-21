<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Job;
use App\Models\Application;
use App\Models\ApplicationStage;

class RecruitmentProcess extends Component
{
    public $job_id;
    public $job;
    public $stages = [];

    public function mount($job_id)
    {
        $this->job_id = $job_id;
        $this->job = Job::with('applications')->findOrFail($job_id);
        $this->loadStages();
    }

    public function loadStages()
    {
        $stageNames = ApplicationStage::getStageNames();
        
        // Get stage statistics
        foreach ($stageNames as $stageName => $stageLabel) {
            $stageData = ApplicationStage::where('stage_name', $stageName)
                ->whereHas('application', function($query) {
                    $query->where('job_id', $this->job_id);
                })
                ->selectRaw('
                    COUNT(*) as total,
                    SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN status = "passed" THEN 1 ELSE 0 END) as passed,
                    SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed
                ')
                ->first();

            $this->stages[] = [
                'name' => $stageName,
                'label' => $stageLabel,
                'total' => $stageData->total ?? 0,
                'pending' => $stageData->pending ?? 0,
                'in_progress' => $stageData->in_progress ?? 0,
                'passed' => $stageData->passed ?? 0,
                'failed' => $stageData->failed ?? 0,
            ];
        }
    }

    public function render()
    {
        return view('livewire.hrd.recruitment-process');
    }
}
