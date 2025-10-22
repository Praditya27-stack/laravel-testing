<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'birth_date',
        'birth_place',
        'gender',
        'marital_status',
        'religion',
        'nationality',
        'id_card_number',
        'completion_percentage',
        'completed_sections',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'completed_sections' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateCompletionPercentage()
    {
        $sections = [
            'personal_info' => 30,
            'education' => 20,
            'experience' => 20,
            'skills' => 10,
            'documents' => 15,
            'references' => 5,
        ];

        $completed = $this->completed_sections ?? [];
        $percentage = 0;

        foreach ($sections as $section => $weight) {
            if (in_array($section, $completed)) {
                $percentage += $weight;
            }
        }

        $this->update(['completion_percentage' => $percentage]);
        
        return $percentage;
    }

    public function isPersonalInfoComplete()
    {
        return !empty($this->full_name) 
            && !empty($this->phone) 
            && !empty($this->address)
            && !empty($this->city)
            && !empty($this->birth_date)
            && !empty($this->gender)
            && !empty($this->id_card_number);
    }

    public function markSectionComplete($section)
    {
        $completed = $this->completed_sections ?? [];
        
        if (!in_array($section, $completed)) {
            $completed[] = $section;
            $this->update(['completed_sections' => $completed]);
            $this->calculateCompletionPercentage();
        }
    }

    public function isProfileComplete()
    {
        return $this->completion_percentage >= 100;
    }
}
