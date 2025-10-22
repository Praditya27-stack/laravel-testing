<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundCheckResponse extends Model
{
    protected $fillable = [
        'request_id',
        'application_id',
        'duration_known',
        'rating_work_performance',
        'rating_attendance',
        'rating_teamwork',
        'rating_integrity',
        'rating_communication',
        'rating_problem_solving',
        'would_recommend',
        'reason_for_leaving',
        'additional_comments',
        'average_rating',
        'total_score',
        'referee_ip_address',
        'referee_user_agent',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'average_rating' => 'decimal:2',
    ];

    public function request()
    {
        return $this->belongsTo(BackgroundCheckRequest::class, 'request_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function result()
    {
        return $this->hasOne(BackgroundCheckResult::class, 'response_id');
    }

    public function calculateScores()
    {
        $ratings = [
            $this->rating_work_performance,
            $this->rating_attendance,
            $this->rating_teamwork,
            $this->rating_integrity,
            $this->rating_communication,
            $this->rating_problem_solving,
        ];

        $validRatings = array_filter($ratings, fn($r) => $r !== null);

        if (empty($validRatings)) {
            return;
        }

        $this->total_score = array_sum($validRatings);
        $this->average_rating = round(array_sum($validRatings) / count($validRatings), 2);
        $this->save();
    }

    public function getSystemSuggestion()
    {
        if (!$this->average_rating) {
            return ['suggestion' => 'review', 'reason' => 'No ratings available'];
        }

        if ($this->average_rating >= 4.0 && $this->would_recommend === 'yes') {
            return ['suggestion' => 'pass', 'reason' => 'High ratings and recommended'];
        }

        if ($this->average_rating < 3.0 || $this->would_recommend === 'no') {
            return ['suggestion' => 'fail', 'reason' => 'Low ratings or not recommended'];
        }

        return ['suggestion' => 'review', 'reason' => 'Borderline ratings, needs manual review'];
    }
}
