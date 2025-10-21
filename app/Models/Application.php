<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'user_id',
        'application_number',
        'current_stage',
        'applied_at',
        'hired_at',
        'rejected_at',
        'rejection_reason',
        'source',
        'cover_letter',
        'notes',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'hired_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stageHistories()
    {
        return $this->hasMany(ApplicationStageHistory::class);
    }

    public function stages()
    {
        return $this->hasMany(ApplicationStage::class)->orderBy('stage_order');
    }

    public function currentStageRecord()
    {
        return $this->hasOne(ApplicationStage::class)
            ->where('status', 'in_progress')
            ->orWhere('status', 'pending')
            ->orderBy('stage_order');
    }

    // Get applicant identity
    public function applicantIdentity()
    {
        return $this->hasOneThrough(
            ApplicantIdentity::class,
            User::class,
            'id',
            'user_id',
            'user_id',
            'id'
        );
    }

    // Initialize stages based on job selection type
    public function initializeStages()
    {
        $job = $this->job;
        
        if ($job->selection_type === 'operator_smk') {
            // 6 stages for Operator SMK
            $stages = [
                ['stage_name' => 'administrative', 'stage_order' => 1],
                ['stage_name' => 'psychotest', 'stage_order' => 2],
                ['stage_name' => 'user_interview', 'stage_order' => 3],
                ['stage_name' => 'background_check', 'stage_order' => 4],
                ['stage_name' => 'mcu', 'stage_order' => 5],
                ['stage_name' => 'offering', 'stage_order' => 6],
            ];
        } else {
            // 7 stages for Staff D3/S1
            $stages = [
                ['stage_name' => 'administrative', 'stage_order' => 1],
                ['stage_name' => 'psychotest', 'stage_order' => 2],
                ['stage_name' => 'hr_interview', 'stage_order' => 3],
                ['stage_name' => 'user_interview', 'stage_order' => 4],
                ['stage_name' => 'background_check', 'stage_order' => 5],
                ['stage_name' => 'mcu', 'stage_order' => 6],
                ['stage_name' => 'offering', 'stage_order' => 7],
            ];
        }

        foreach ($stages as $stage) {
            $this->stages()->create([
                'stage_name' => $stage['stage_name'],
                'stage_order' => $stage['stage_order'],
                'status' => $stage['stage_order'] === 1 ? 'in_progress' : 'pending',
                'started_at' => $stage['stage_order'] === 1 ? now() : null,
            ]);
        }

        $this->update(['current_stage' => 'administrative']);
    }

    // Move to next stage
    public function moveToNextStage()
    {
        $currentStage = $this->stages()->where('status', 'passed')->orderBy('stage_order', 'desc')->first();
        
        if (!$currentStage) {
            return false;
        }

        $nextStage = $this->stages()->where('stage_order', '>', $currentStage->stage_order)->first();
        
        if ($nextStage) {
            $nextStage->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
            
            $this->update(['current_stage' => $nextStage->stage_name]);
            return true;
        }

        return false;
    }
}
