<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Relationships
     */
    public function applicantIdentity()
    {
        return $this->hasOne(\App\Models\ApplicantIdentity::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

    // New Profile System
    public function profile()
    {
        return $this->hasOne(\App\Models\ApplicantProfile::class);
    }

    public function educations()
    {
        return $this->hasMany(\App\Models\ApplicantEducation::class);
    }

    public function experiences()
    {
        return $this->hasMany(\App\Models\ApplicantExperience::class);
    }

    public function skills()
    {
        return $this->hasMany(\App\Models\ApplicantSkill::class);
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\ApplicantDocument::class);
    }

    public function references()
    {
        return $this->hasMany(\App\Models\ApplicantReference::class);
    }

    public function identity()
    {
        return $this->hasOne(\App\Models\ApplicantIdentity::class);
    }

    public function formalEducations()
    {
        return $this->hasMany(\App\Models\FormalEducation::class);
    }

    public function nonFormalEducations()
    {
        return $this->hasMany(\App\Models\NonFormalEducation::class);
    }

    public function languageSkills()
    {
        return $this->hasMany(\App\Models\LanguageSkill::class);
    }

    public function organizationExperiences()
    {
        return $this->hasMany(\App\Models\OrganizationExperience::class);
    }

    public function maritalStatus()
    {
        return $this->hasOne(\App\Models\MaritalStatus::class);
    }

    public function spousesAndChildren()
    {
        return $this->hasMany(\App\Models\SpousesAndChildren::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(\App\Models\FamilyMember::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(\App\Models\WorkExperience::class);
    }

    public function motivations()
    {
        return $this->hasOne(\App\Models\ApplicantMotivation::class);
    }

    public function departmentPreferences()
    {
        return $this->hasMany(\App\Models\DepartmentPreference::class);
    }

    public function hobbies()
    {
        return $this->hasMany(\App\Models\ApplicantHobby::class);
    }

    public function strengthsWeaknesses()
    {
        return $this->hasOne(\App\Models\ApplicantStrengthsWeaknesses::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(\App\Models\MedicalHistory::class);
    }

    public function previousApplications()
    {
        return $this->hasMany(\App\Models\PreviousApplication::class);
    }

    public function getProfileCompletionPercentage()
    {
        $profile = $this->profile;
        return $profile ? $profile->completion_percentage : 0;
    }

    public function canApplyForJobs()
    {
        return $this->getProfileCompletionPercentage() >= 100;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
