<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\Job;
use Illuminate\Support\Str;

class JobPosting extends Component
{
    // Section 1: General Information
    public $publish_date;
    public $end_date;
    
    // Section 2: Vacancy Information
    public $vacancy_title = '';
    public $position = '';
    public $education_level = '';
    public $category = '';
    public $function = '';
    public $company = '';
    public $description = '';
    public $skills_input = '';
    public $skills_required = [];
    public $total_needed = 1;
    
    // Section 3: Selection Process Type
    public $selection_type = '';
    
    // Edit mode
    public $job_id = null;
    public $is_edit = false;
    
    // Dropdown options
    public $positions = [
        'PKL/Magang Mahasiswa Aktif',
        'Operator',
        'Staff',
        'Leader',
        'Supervisor',
        'Section Head',
        'Manager',
        'General Manager',
    ];
    
    public $education_levels = [
        'SMK/SMA',
        'Diploma 3 - D3',
        'Strata 1 - S1',
    ];
    
    public $categories = [
        'Mahasiswa Aktif',
        'Fresh Graduate',
        'Professional',
        'All',
    ];
    
    public $functions = [
        'Engineering',
        'Production',
        'Management System & SHE',
        'MIS/IT',
        'Human Capital',
        'Marketing',
        'Finance & Accounting',
        'Corporate Planning',
        'Purchasing',
    ];
    
    public $companies = [
        'PT Aisin Indonesia',
        'PT Aisin Indonesia Automotive',
    ];
    
    public $selection_types = [
        'operator_smk' => 'Seleksi Operator SMK',
        'staff_d3s1' => 'Seleksi Staff Level Up D3/S1',
    ];

    protected $rules = [
        'publish_date' => 'required|date',
        'end_date' => 'required|date|after:publish_date',
        'vacancy_title' => 'required|string|max:255',
        'position' => 'required|string',
        'education_level' => 'required|string',
        'category' => 'required|string',
        'function' => 'required|string',
        'company' => 'required|string',
        'description' => 'required|string|min:50',
        'total_needed' => 'required|integer|min:1',
        'selection_type' => 'required|string|in:operator_smk,staff_d3s1',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->job_id = $id;
            $this->is_edit = true;
            $this->loadJob($id);
        }
    }

    public function loadJob($id)
    {
        $job = Job::findOrFail($id);
        
        $this->publish_date = $job->publish_date?->format('Y-m-d');
        $this->end_date = $job->end_date?->format('Y-m-d');
        $this->vacancy_title = $job->vacancy_title;
        $this->position = $job->position;
        $this->education_level = $job->education_level;
        $this->category = $job->category;
        $this->function = $job->function;
        $this->company = $job->company;
        $this->description = $job->description;
        $this->skills_required = $job->skills_required ?? [];
        $this->total_needed = $job->total_needed ?? 1;
        $this->selection_type = $job->selection_type;
    }

    public function addSkill()
    {
        if (!empty($this->skills_input)) {
            $this->skills_required[] = trim($this->skills_input);
            $this->skills_input = '';
        }
    }

    public function removeSkill($index)
    {
        unset($this->skills_required[$index]);
        $this->skills_required = array_values($this->skills_required);
    }

    public function submit()
    {
        $this->validate();

        $data = [
            'code' => $this->generateJobCode(),
            'title' => $this->vacancy_title,
            'slug' => Str::slug($this->vacancy_title),
            'publish_date' => $this->publish_date,
            'end_date' => $this->end_date,
            'vacancy_title' => $this->vacancy_title,
            'position' => $this->position,
            'education_level' => $this->education_level,
            'category' => $this->category,
            'function' => $this->function,
            'company' => $this->company,
            'description' => $this->description,
            'skills_required' => $this->skills_required,
            'total_needed' => $this->total_needed,
            'selection_type' => $this->selection_type,
            'status' => 'open',
            'posted_at' => now(),
        ];

        if ($this->is_edit) {
            $job = Job::findOrFail($this->job_id);
            $job->update($data);
            session()->flash('success', 'Job vacancy updated successfully!');
        } else {
            Job::create($data);
            session()->flash('success', 'Job vacancy posted successfully!');
        }

        return redirect()->route('hrd.jobs.index');
    }

    public function saveDraft()
    {
        $this->validate([
            'vacancy_title' => 'required|string|max:255',
        ]);

        $data = [
            'code' => $this->generateJobCode(),
            'title' => $this->vacancy_title,
            'slug' => Str::slug($this->vacancy_title),
            'publish_date' => $this->publish_date,
            'end_date' => $this->end_date,
            'vacancy_title' => $this->vacancy_title,
            'position' => $this->position,
            'education_level' => $this->education_level,
            'category' => $this->category,
            'function' => $this->function,
            'company' => $this->company,
            'description' => $this->description,
            'skills_required' => $this->skills_required,
            'total_needed' => $this->total_needed,
            'selection_type' => $this->selection_type,
            'status' => 'draft',
        ];

        if ($this->is_edit) {
            $job = Job::findOrFail($this->job_id);
            $job->update($data);
        } else {
            Job::create($data);
        }

        session()->flash('success', 'Job saved as draft!');
        return redirect()->route('hrd.jobs.index');
    }

    public function clearForm()
    {
        $this->reset();
    }

    private function generateJobCode()
    {
        if ($this->is_edit) {
            return Job::find($this->job_id)->code;
        }
        
        $prefix = 'JOB';
        $year = date('Y');
        $month = date('m');
        
        $lastJob = Job::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastJob ? (int)substr($lastJob->code, -4) + 1 : 1;
        
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    public function render()
    {
        return view('livewire.hrd.job-posting')->layout('layouts.hrd');
    }
}
