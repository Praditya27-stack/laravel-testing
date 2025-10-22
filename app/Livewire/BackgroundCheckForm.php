<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BackgroundCheckRequest;
use App\Models\BackgroundCheckResponse;
use Illuminate\Support\Facades\Request;

class BackgroundCheckForm extends Component
{
    public $token;
    public $request;
    public $isValid = false;
    public $isExpired = false;
    public $isCompleted = false;
    
    // Form Fields
    public $duration_known = '';
    public $rating_work_performance = null;
    public $rating_attendance = null;
    public $rating_teamwork = null;
    public $rating_integrity = null;
    public $rating_communication = null;
    public $rating_problem_solving = null;
    public $would_recommend = '';
    public $reason_for_leaving = '';
    public $additional_comments = '';
    
    // Submission
    public $submitted = false;

    protected $rules = [
        'duration_known' => 'required|string',
        'rating_work_performance' => 'required|integer|min:1|max:5',
        'rating_attendance' => 'required|integer|min:1|max:5',
        'rating_teamwork' => 'required|integer|min:1|max:5',
        'rating_integrity' => 'required|integer|min:1|max:5',
        'rating_communication' => 'required|integer|min:1|max:5',
        'rating_problem_solving' => 'required|integer|min:1|max:5',
        'would_recommend' => 'required|in:yes,no,maybe',
        'reason_for_leaving' => 'required|string|min:10',
        'additional_comments' => 'nullable|string',
    ];

    protected $messages = [
        'duration_known.required' => 'Please specify how long you have known the candidate',
        'rating_*.required' => 'Please provide a rating for this criterion',
        'rating_*.min' => 'Rating must be at least 1',
        'rating_*.max' => 'Rating must not exceed 5',
        'would_recommend.required' => 'Please indicate if you would recommend this candidate',
        'reason_for_leaving.required' => 'Please provide the reason for leaving',
        'reason_for_leaving.min' => 'Please provide more details (minimum 10 characters)',
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->validateToken();
    }

    public function validateToken()
    {
        $this->request = BackgroundCheckRequest::with([
            'application.user',
            'application.job',
            'referee',
            'response'
        ])->where('token', $this->token)->first();

        if (!$this->request) {
            $this->isValid = false;
            return;
        }

        if ($this->request->status === 'completed') {
            $this->isCompleted = true;
            return;
        }

        if ($this->request->isExpired()) {
            $this->isExpired = true;
            $this->request->update(['status' => 'expired']);
            return;
        }

        $this->isValid = true;
    }

    public function submitForm()
    {
        $this->validate();

        // Create response
        $response = BackgroundCheckResponse::create([
            'request_id' => $this->request->id,
            'application_id' => $this->request->application_id,
            'duration_known' => $this->duration_known,
            'rating_work_performance' => $this->rating_work_performance,
            'rating_attendance' => $this->rating_attendance,
            'rating_teamwork' => $this->rating_teamwork,
            'rating_integrity' => $this->rating_integrity,
            'rating_communication' => $this->rating_communication,
            'rating_problem_solving' => $this->rating_problem_solving,
            'would_recommend' => $this->would_recommend,
            'reason_for_leaving' => $this->reason_for_leaving,
            'additional_comments' => $this->additional_comments,
            'referee_ip_address' => Request::ip(),
            'referee_user_agent' => Request::userAgent(),
            'submitted_at' => now(),
        ]);

        // Calculate scores
        $response->calculateScores();

        // Mark request as completed
        $this->request->markAsCompleted();

        // TODO: Send thank you email to referee
        // TODO: Notify HR about completed form

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.background-check-form')->layout('layouts.guest');
    }
}
