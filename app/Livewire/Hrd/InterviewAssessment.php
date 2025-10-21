<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Interview;
use App\Models\InterviewAssessment as AssessmentModel;
use Illuminate\Support\Facades\Auth;

class InterviewAssessment extends Component
{
    public $interviewId;
    public $interview;
    
    // Scoring (1-10 scale)
    public $technicalCompetence;
    public $communicationSkills;
    public $problemSolving;
    public $culturalFit;
    public $attitude;
    public $overallImpression;
    
    // Qualitative feedback
    public $strengths;
    public $weaknesses;
    public $recommendation;
    
    // Decision
    public $decision = 'pending';
    public $decisionNotes;

    protected $rules = [
        'technicalCompetence' => 'required|integer|min:1|max:10',
        'communicationSkills' => 'required|integer|min:1|max:10',
        'problemSolving' => 'required|integer|min:1|max:10',
        'culturalFit' => 'required|integer|min:1|max:10',
        'attitude' => 'required|integer|min:1|max:10',
        'overallImpression' => 'required|integer|min:1|max:10',
        'strengths' => 'required|min:20',
        'weaknesses' => 'required|min:20',
        'recommendation' => 'required|min:20',
        'decision' => 'required|in:passed,failed,pending',
    ];

    public function mount($interviewId)
    {
        $this->interviewId = $interviewId;
        $this->interview = Interview::with(['application.user', 'job'])->findOrFail($interviewId);
        
        // Load existing assessment if any
        $existingAssessment = $this->interview->assessment;
        if ($existingAssessment) {
            $this->technicalCompetence = $existingAssessment->technical_competence;
            $this->communicationSkills = $existingAssessment->communication_skills;
            $this->problemSolving = $existingAssessment->problem_solving;
            $this->culturalFit = $existingAssessment->cultural_fit;
            $this->attitude = $existingAssessment->attitude;
            $this->overallImpression = $existingAssessment->overall_impression;
            $this->strengths = $existingAssessment->strengths;
            $this->weaknesses = $existingAssessment->weaknesses;
            $this->recommendation = $existingAssessment->recommendation;
            $this->decision = $existingAssessment->decision;
            $this->decisionNotes = $existingAssessment->decision_notes;
        }
    }

    public function getTotalScore()
    {
        $scores = [
            $this->technicalCompetence,
            $this->communicationSkills,
            $this->problemSolving,
            $this->culturalFit,
            $this->attitude,
            $this->overallImpression,
        ];

        $validScores = array_filter($scores, fn($score) => $score !== null);
        
        if (empty($validScores)) {
            return 0;
        }

        return round(array_sum($validScores) / count($validScores), 2);
    }

    public function saveAssessment()
    {
        $this->validate();

        $totalScore = $this->getTotalScore();

        // Create or update assessment
        $assessment = AssessmentModel::updateOrCreate(
            [
                'interview_schedule_id' => $this->interviewId,
                'application_id' => $this->interview->application_id,
            ],
            [
                'assessor_id' => Auth::id(),
                'assessor_role' => Auth::user()->hasRole('hr_recruiter') ? 'interviewer' : 'dept_user',
                'technical_competence' => $this->technicalCompetence,
                'communication_skills' => $this->communicationSkills,
                'problem_solving' => $this->problemSolving,
                'cultural_fit' => $this->culturalFit,
                'attitude' => $this->attitude,
                'overall_impression' => $this->overallImpression,
                'total_score' => $totalScore,
                'strengths' => $this->strengths,
                'weaknesses' => $this->weaknesses,
                'recommendation' => $this->recommendation,
                'decision' => $this->decision,
                'decision_notes' => $this->decisionNotes,
            ]
        );

        // Mark interview as completed
        $this->interview->markAsCompleted();

        // If passed, move to next stage
        if ($this->decision === 'passed') {
            $this->interview->application->moveToNextStage();
        }

        session()->flash('success', '✅ Assessment berhasil disimpan!');
        
        return redirect()->route('hrd.interview.results');
    }

    public function render()
    {
        $totalScore = $this->getTotalScore();
        
        return view('livewire.hrd.interview-assessment', [
            'totalScore' => $totalScore,
        ]);
    }
}
