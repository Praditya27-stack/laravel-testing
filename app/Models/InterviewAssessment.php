<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewAssessment extends Model
{
    protected $fillable = [
        'interview_schedule_id',
        'application_id',
        'assessor_id',
        'assessor_role',
        'technical_competence',
        'communication_skills',
        'problem_solving',
        'cultural_fit',
        'attitude',
        'overall_impression',
        'total_score',
        'strengths',
        'weaknesses',
        'recommendation',
        'decision',
        'decision_notes',
        'is_overridden',
        'overridden_by',
        'override_reason',
        'overridden_at',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'is_overridden' => 'boolean',
        'overridden_at' => 'datetime',
    ];

    // Relationships
    public function interview()
    {
        return $this->belongsTo(Interview::class, 'interview_schedule_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    public function overriddenBy()
    {
        return $this->belongsTo(User::class, 'overridden_by');
    }

    // Calculate total score
    public function calculateTotalScore()
    {
        $scores = [
            $this->technical_competence,
            $this->communication_skills,
            $this->problem_solving,
            $this->cultural_fit,
            $this->attitude,
            $this->overall_impression,
        ];

        $validScores = array_filter($scores, fn($score) => $score !== null);
        
        if (empty($validScores)) {
            return 0;
        }

        $average = array_sum($validScores) / count($validScores);
        
        $this->update(['total_score' => round($average, 2)]);
        
        return $this->total_score;
    }

    // Get grade based on score
    public function getGrade()
    {
        $score = $this->total_score;
        
        if ($score >= 9) return 'A';
        if ($score >= 8) return 'B';
        if ($score >= 7) return 'C';
        if ($score >= 6) return 'D';
        return 'E';
    }
}
