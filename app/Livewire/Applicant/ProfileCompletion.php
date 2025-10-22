<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ApplicantProfile;
use App\Models\ApplicantEducation;
use App\Models\ApplicantExperience;
use App\Models\ApplicantSkill;
use App\Models\ApplicantDocument;
use App\Models\ApplicantReference;

class ProfileCompletion extends Component
{
    use WithFileUploads;

    public $activeSection = 'identity';
    public $profile;
    public $completionPercentage = 0;

    // A. Identity
    public $identity_full_name, $identity_birth_place, $identity_birth_date, $identity_driving_license_types;
    public $identity_driving_license_number, $identity_national_id_number, $identity_phone_number, $identity_parent_phone;
    public $identity_address_ktp, $identity_address_domicile, $identity_email, $identity_religion, $identity_gender;
    public $identity_blood_type, $identity_height_cm, $identity_weight_kg, $identity_shirt_size, $identity_pants_size, $identity_shoe_size;

    // B. Education
    public $nonFormalEducations = [], $languageSkills = [], $organizations = [];

    // C. Family
    public $marital_status_ktp, $marital_status_actual, $marital_date;
    public $spouse_name, $spouse_gender, $spouse_birth, $spouse_education, $spouse_occupation;
    public $children = [], $father_name, $father_birth, $father_education, $father_occupation;
    public $mother_name, $mother_birth, $mother_education, $mother_occupation, $siblings = [];

    // D. Work
    public $workExperiences = [];

    // E. Motivation
    public $motivation_skills, $motivation_reason, $motivation_why_company, $motivation_expected_salary;
    public $motivation_start_date, $motivation_relative_name, $motivation_relative_relation;

    // F. References
    public $ref_name, $ref_relationship, $ref_company, $ref_position, $ref_phone, $ref_email;

    // G. Others
    public $prev_psychotest = 'belum', $prevPsychotests = [], $hobbies, $free_time_activity;
    public $strengths, $weaknesses, $has_medical_history = 'tidak', $medicalHistories = [];

    public function mount()
    {
        $user = auth()->user();
        
        // Get or create profile
        $this->profile = $user->profile ?? ApplicantProfile::create([
            'user_id' => $user->id,
            'full_name' => $user->name,
        ]);

        // Load existing identity data
        if ($user->identity) {
            $identity = $user->identity;
            $this->identity_full_name = $identity->full_name;
            $this->identity_birth_place = $identity->birth_place;
            $this->identity_birth_date = $identity->birth_date;
            $this->identity_driving_license_types = $identity->driving_license_types;
            $this->identity_driving_license_number = $identity->driving_license_number;
            $this->identity_national_id_number = $identity->national_id_number;
            $this->identity_phone_number = $identity->phone_number;
            $this->identity_parent_phone = $identity->parent_phone;
            $this->identity_address_ktp = $identity->address_ktp;
            $this->identity_address_domicile = $identity->address_domicile;
            $this->identity_email = $identity->email;
            $this->identity_religion = $identity->religion;
            $this->identity_gender = $identity->gender;
            $this->identity_blood_type = $identity->blood_type;
            $this->identity_height_cm = $identity->height_cm;
            $this->identity_weight_kg = $identity->weight_kg;
            $this->identity_shirt_size = $identity->shirt_size;
            $this->identity_pants_size = $identity->pants_size;
            $this->identity_shoe_size = $identity->shoe_size;
        } else {
            // Auto-fill from user data
            $this->identity_full_name = $user->name;
            $this->identity_email = $user->email;
        }

        $this->calculateCompletion();
    }

    public function loadPersonalInfo()
    {
        $this->full_name = $this->profile->full_name;
        $this->phone = $this->profile->phone;
        $this->address = $this->profile->address;
        $this->city = $this->profile->city;
        $this->province = $this->profile->province;
        $this->postal_code = $this->profile->postal_code;
        $this->birth_date = $this->profile->birth_date?->format('Y-m-d');
        $this->birth_place = $this->profile->birth_place;
        $this->gender = $this->profile->gender;
        $this->marital_status = $this->profile->marital_status;
        $this->religion = $this->profile->religion;
        $this->id_card_number = $this->profile->id_card_number;
    }

    public function savePersonalInfo()
    {
        $this->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'birth_date' => 'required|date',
            'gender' => 'required',
            'id_card_number' => 'required',
        ]);

        $this->profile->update([
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'birth_date' => $this->birth_date,
            'birth_place' => $this->birth_place,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'religion' => $this->religion,
            'id_card_number' => $this->id_card_number,
        ]);

        if ($this->profile->isPersonalInfoComplete()) {
            $this->profile->markSectionComplete('personal_info');
        }

        session()->flash('message', 'Personal information saved!');
        $this->calculateCompletion();
    }

    public function addEducation()
    {
        $this->validate([
            'edu_level' => 'required',
            'edu_institution' => 'required',
            'edu_start_year' => 'required',
        ]);

        ApplicantEducation::create([
            'user_id' => auth()->id(),
            'level' => $this->edu_level,
            'institution_name' => $this->edu_institution,
            'major' => $this->edu_major,
            'gpa' => $this->edu_gpa,
            'start_year' => $this->edu_start_year,
            'end_year' => $this->edu_end_year,
        ]);

        $this->reset(['edu_level', 'edu_institution', 'edu_major', 'edu_gpa', 'edu_start_year', 'edu_end_year']);
        
        if (auth()->user()->educations()->count() >= 1) {
            $this->profile->markSectionComplete('education');
        }

        session()->flash('message', 'Education added!');
        $this->calculateCompletion();
    }

    public function deleteEducation($id)
    {
        ApplicantEducation::where('id', $id)->where('user_id', auth()->id())->delete();
        $this->calculateCompletion();
    }

    public function addExperience()
    {
        $this->validate([
            'exp_company' => 'required',
            'exp_position' => 'required',
            'exp_start_date' => 'required|date',
        ]);

        ApplicantExperience::create([
            'user_id' => auth()->id(),
            'company_name' => $this->exp_company,
            'position' => $this->exp_position,
            'job_description' => $this->exp_description,
            'start_date' => $this->exp_start_date,
            'end_date' => $this->exp_is_current ? null : $this->exp_end_date,
            'is_current' => $this->exp_is_current,
        ]);

        $this->reset(['exp_company', 'exp_position', 'exp_description', 'exp_start_date', 'exp_end_date', 'exp_is_current']);
        
        if (auth()->user()->experiences()->count() >= 1) {
            $this->profile->markSectionComplete('experience');
        }

        session()->flash('message', 'Experience added!');
        $this->calculateCompletion();
    }

    public function deleteExperience($id)
    {
        ApplicantExperience::where('id', $id)->where('user_id', auth()->id())->delete();
        $this->calculateCompletion();
    }

    public function addSkill()
    {
        $this->validate(['skill_name' => 'required']);

        ApplicantSkill::create([
            'user_id' => auth()->id(),
            'skill_name' => $this->skill_name,
            'proficiency_level' => $this->skill_proficiency,
        ]);

        $this->reset(['skill_name', 'skill_proficiency']);
        
        if (auth()->user()->skills()->count() >= 3) {
            $this->profile->markSectionComplete('skills');
        }

        session()->flash('message', 'Skill added!');
        $this->calculateCompletion();
    }

    public function deleteSkill($id)
    {
        ApplicantSkill::where('id', $id)->where('user_id', auth()->id())->delete();
        
        // Check if still meets requirement
        if (auth()->user()->fresh()->skills()->count() < 3) {
            $completed = $this->profile->completed_sections ?? [];
            $this->profile->update([
                'completed_sections' => array_diff($completed, ['skills'])
            ]);
        }
        
        $this->calculateCompletion();
    }

    public function uploadCV()
    {
        $this->validate(['cv_file' => 'required|file|max:2048']);
        $this->uploadDocumentType('cv', $this->cv_file);
        $this->reset('cv_file');
    }

    public function uploadKTP()
    {
        $this->validate(['ktp_file' => 'required|file|max:2048']);
        $this->uploadDocumentType('ktp', $this->ktp_file);
        $this->reset('ktp_file');
    }

    public function uploadIjazah()
    {
        $this->validate(['ijazah_file' => 'required|file|max:2048']);
        $this->uploadDocumentType('ijazah', $this->ijazah_file);
        $this->reset('ijazah_file');
    }

    public function uploadFoto()
    {
        $this->validate(['foto_file' => 'required|file|max:2048']);
        $this->uploadDocumentType('foto', $this->foto_file);
        $this->reset('foto_file');
    }

    private function uploadDocumentType($type, $file)
    {
        $path = $file->store('applicant-documents', 'public');

        ApplicantDocument::create([
            'user_id' => auth()->id(),
            'document_type' => $type,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);

        $requiredDocs = ['cv', 'ktp', 'ijazah'];
        $uploadedTypes = auth()->user()->documents()->pluck('document_type')->toArray();
        
        if (count(array_intersect($requiredDocs, $uploadedTypes)) >= 3) {
            $this->profile->markSectionComplete('documents');
        }

        session()->flash('message', strtoupper($type) . ' uploaded successfully!');
        $this->calculateCompletion();
    }

    public function deleteDocument($id)
    {
        $doc = ApplicantDocument::where('id', $id)->where('user_id', auth()->id())->first();
        if ($doc) {
            \Storage::disk('public')->delete($doc->file_path);
            $doc->delete();
        }
        $this->calculateCompletion();
    }

    public function addReference()
    {
        $this->validate([
            'ref_name' => 'required',
            'ref_relationship' => 'required',
            'ref_company' => 'required',
            'ref_phone' => 'required',
        ]);

        ApplicantReference::create([
            'user_id' => auth()->id(),
            'name' => $this->ref_name,
            'relationship' => $this->ref_relationship,
            'company' => $this->ref_company,
            'position' => $this->ref_position,
            'phone' => $this->ref_phone,
            'email' => $this->ref_email,
        ]);

        $this->reset(['ref_name', 'ref_relationship', 'ref_company', 'ref_position', 'ref_phone', 'ref_email']);
        
        if (auth()->user()->references()->count() >= 2) {
            $this->profile->markSectionComplete('references');
        }

        session()->flash('message', 'Reference added!');
        $this->calculateCompletion();
    }

    public function deleteReference($id)
    {
        ApplicantReference::where('id', $id)->where('user_id', auth()->id())->delete();
        $this->calculateCompletion();
    }

    public function calculateCompletion()
    {
        $user = auth()->user();
        $completed = 0;
        $total = 7; // 7 sections (A-G)
        
        // A. Identity (check if exists)
        if ($user->identity && $user->identity->full_name && $user->identity->national_id_number) {
            $completed++;
        }
        
        // B. Education (check formal education)
        if ($user->formalEducations()->count() >= 1) {
            $completed++;
        }
        
        // C. Family (check marital status)
        if ($user->maritalStatus) {
            $completed++;
        }
        
        // D. Work (optional - auto complete)
        $completed++;
        
        // E. Motivation (check if exists)
        if ($user->motivations && $user->motivations->expected_salary) {
            $completed++;
        }
        
        // F. References (check minimum 3)
        if ($user->references()->count() >= 3) {
            $completed++;
        }
        
        // G. Others (check hobbies/strengths)
        if ($user->hobbies()->count() > 0 || $user->strengthsWeaknesses) {
            $completed++;
        }
        
        $percentage = round(($completed / $total) * 100);
        
        $this->profile->update(['completion_percentage' => $percentage]);
        $this->completionPercentage = $percentage;
    }

    public function setActiveSection($section)
    {
        $this->activeSection = $section;
    }

    // A. Identity
    public function saveIdentity()
    {
        try {
            $this->validate([
                'identity_full_name' => 'required|min:3',
                'identity_birth_place' => 'required',
                'identity_birth_date' => 'required|date',
                'identity_national_id_number' => 'required|numeric|digits:16',
                'identity_phone_number' => 'required|min:10',
                'identity_address_ktp' => 'required|min:10',
                'identity_address_domicile' => 'required|min:10',
                'identity_email' => 'required|email',
                'identity_religion' => 'required',
                'identity_gender' => 'required|in:L,P',
            ]);

            \App\Models\ApplicantIdentity::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'full_name' => $this->identity_full_name,
                'birth_place' => $this->identity_birth_place,
                'birth_date' => $this->identity_birth_date,
                'driving_license_types' => $this->identity_driving_license_types,
                'driving_license_number' => $this->identity_driving_license_number,
                'national_id_number' => $this->identity_national_id_number,
                'phone_number' => $this->identity_phone_number,
                'parent_phone' => $this->identity_parent_phone,
                'address_ktp' => $this->identity_address_ktp,
                'address_domicile' => $this->identity_address_domicile,
                'email' => $this->identity_email,
                'religion' => $this->identity_religion,
                'gender' => $this->identity_gender,
                'blood_type' => $this->identity_blood_type,
                'height_cm' => $this->identity_height_cm,
                'weight_kg' => $this->identity_weight_kg,
                'shirt_size' => $this->identity_shirt_size,
                'pants_size' => $this->identity_pants_size,
                'shoe_size' => $this->identity_shoe_size,
            ]
        );
        
            $this->calculateCompletion();
            session()->flash('message', '✅ Identitas berhasil disimpan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            \Log::error('Save Identity Error: ' . $e->getMessage());
        }
    }

    // B. Education helpers
    public function addNonFormalEducation() { $this->nonFormalEducations[] = ['name'=>'','place'=>'','period'=>'','notes'=>'']; }
    public function removeNonFormalEducation($i) { unset($this->nonFormalEducations[$i]); }
    public function addLanguageSkill() { $this->languageSkills[] = ['language'=>'','writing'=>'','reading'=>'','grammar'=>'','notes'=>'']; }
    public function removeLanguageSkill($i) { unset($this->languageSkills[$i]); }
    public function addOrganization() { $this->organizations[] = ['name'=>'','place'=>'','position'=>'','period'=>'']; }
    public function removeOrganization($i) { unset($this->organizations[$i]); }
    
    public function saveEducation()
    {
        try {
            // Save non-formal educations
            foreach ($this->nonFormalEducations as $edu) {
                if (!empty($edu['name'])) {
                    \App\Models\NonFormalEducation::create([
                        'user_id' => auth()->id(),
                        'name' => $edu['name'],
                        'place' => $edu['place'],
                        'period' => $edu['period'],
                        'notes' => $edu['notes'],
                    ]);
                }
            }
            
            // Save language skills
            foreach ($this->languageSkills as $lang) {
                if (!empty($lang['language'])) {
                    \App\Models\LanguageSkill::create([
                        'user_id' => auth()->id(),
                        'language' => $lang['language'],
                        'writing' => $lang['writing'],
                        'reading' => $lang['reading'],
                        'grammar' => $lang['grammar'],
                        'notes' => $lang['notes'],
                    ]);
                }
            }
            
            // Save organizations
            foreach ($this->organizations as $org) {
                if (!empty($org['name'])) {
                    \App\Models\OrganizationExperience::create([
                        'user_id' => auth()->id(),
                        'name' => $org['name'],
                        'place' => $org['place'],
                        'position' => $org['position'],
                        'period' => $org['period'],
                    ]);
                }
            }
            
            $this->calculateCompletion();
            session()->flash('message', '✅ Pendidikan berhasil disimpan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    // C. Family helpers
    public function addChild() { $this->children[] = ['name'=>'','gender'=>'','birth'=>'','education'=>'','occupation'=>'']; }
    public function removeChild($i) { unset($this->children[$i]); }
    public function addSibling() { $this->siblings[] = ['name'=>'','gender'=>'','birth'=>'','education'=>'','occupation'=>'']; }
    public function removeSibling($i) { unset($this->siblings[$i]); }

    public function saveFamily()
    {
        \App\Models\MaritalStatus::updateOrCreate(['user_id'=>auth()->id()],['status_ktp'=>$this->marital_status_ktp,'status_actual'=>$this->marital_status_actual,'date'=>$this->marital_date]);
        session()->flash('message', 'Family data saved!');
    }

    // D. Work
    public function addWorkExperience() { $this->workExperiences[] = ['company'=>'','position'=>'','salary'=>'','period'=>'','reason'=>'']; }
    public function removeWorkExperience($i) { unset($this->workExperiences[$i]); }
    public function saveWorkHistory() { session()->flash('message', 'Work history saved!'); }

    // E. Motivation
    public function saveMotivation()
    {
        \App\Models\ApplicantMotivation::updateOrCreate(['user_id'=>auth()->id()],['skills'=>$this->motivation_skills,'reason_to_work'=>$this->motivation_reason,'why_company'=>$this->motivation_why_company,'expected_salary'=>$this->motivation_expected_salary,'available_start_date'=>$this->motivation_start_date]);
        session()->flash('message', 'Motivation saved!');
    }

    // G. Others helpers
    public function addPrevPsychotest() { $this->prevPsychotests[] = ['organizer'=>'','process'=>'','time'=>'']; }
    public function removePrevPsychotest($i) { unset($this->prevPsychotests[$i]); }
    public function addMedicalHistory() { $this->medicalHistories[] = ['disease'=>'','status'=>'','since'=>'','notes'=>'']; }
    public function removeMedicalHistory($i) { unset($this->medicalHistories[$i]); }
    public function saveOthers()
    {
        \App\Models\ApplicantHobby::updateOrCreate(['user_id'=>auth()->id()],['hobbies'=>$this->hobbies,'free_time_activity'=>$this->free_time_activity]);
        \App\Models\ApplicantStrengthsWeaknesses::updateOrCreate(['user_id'=>auth()->id()],['strengths'=>$this->strengths,'weaknesses'=>$this->weaknesses]);
        session()->flash('message', 'Others saved!');
    }

    public function render()
    {
        return view('livewire.applicant.profile-completion', [
            'educations' => auth()->user()->educations,
            'experiences' => auth()->user()->experiences,
            'skills' => auth()->user()->skills,
            'documents' => auth()->user()->documents,
            'references' => auth()->user()->references,
        ])->layout('layouts.landing');
    }
}
