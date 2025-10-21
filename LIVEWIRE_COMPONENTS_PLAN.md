# Livewire Components Plan - PT Aisin Recruitment System

**Purpose:** Plan for Livewire components to build interactive UI without CDN

---

## 🎯 Why Livewire?

- ✅ **No CDN Required** - All assets served locally
- ✅ **Real-time Interactivity** - Without building SPA
- ✅ **Laravel Native** - Uses Blade templates
- ✅ **Easy File Uploads** - Built-in file upload handling
- ✅ **Modal Support** - Dynamic modals without JavaScript
- ✅ **Form Validation** - Real-time validation
- ✅ **Pagination** - Built-in pagination

---

## 📦 Components to Create

### 1. Public/Applicant Components

#### JobList Component
**Purpose:** Display available job vacancies with filters

**Features:**
- Search by job title, department, location
- Filter by education level, category, function
- Sort by date, salary, position
- Pagination
- View job details modal

**Command:**
```bash
php artisan make:livewire JobList
```

**File Structure:**
- `app/Livewire/JobList.php`
- `resources/views/livewire/job-list.blade.php`

---

#### JobDetail Component
**Purpose:** Show detailed job information

**Features:**
- Job description
- Requirements
- Skills required
- Apply button
- Share job

**Command:**
```bash
php artisan make:livewire JobDetail
```

---

#### ApplicationForm Component
**Purpose:** Multi-step application form

**Features:**
- Step 1: Identity (Section A)
- Step 2: Education (Section B)
- Step 3: Family (Section C)
- Step 4: Work Experience (Section D)
- Step 5: Skills & Motivation (Section E)
- Step 6: Background & Others (Sections F & G)
- Progress indicator
- Save draft
- File uploads (CV, photo, certificates)
- PDP consent checkbox
- Profile completion percentage

**Command:**
```bash
php artisan make:livewire ApplicationForm
```

---

#### ApplicantDashboard Component
**Purpose:** Applicant's personal dashboard

**Features:**
- Profile completion indicator
- Active applications list
- Application status tracking
- Interview schedule
- Notifications
- Document uploads

**Command:**
```bash
php artisan make:livewire ApplicantDashboard
```

---

#### ProfileCompletion Component
**Purpose:** Show profile completion progress

**Features:**
- Percentage indicator (0-100%)
- Missing sections list
- Quick links to complete sections
- Visual progress bar

**Command:**
```bash
php artisan make:livewire ProfileCompletion
```

---

#### InterviewConfirmation Component
**Purpose:** Candidate confirms/declines interview

**Features:**
- Interview details display
- Confirm button
- Decline button with reason
- Download ICS calendar
- Reminder settings

**Command:**
```bash
php artisan make:livewire InterviewConfirmation
```

---

### 2. Admin/HR Components

#### ApplicationReview Component
**Purpose:** Review applications with filters

**Features:**
- Filter by stage, status, date, education
- Sort by name, date, GPA, experience, age
- Bulk actions
- Quick view modal
- Move to next stage
- Reject with reason

**Command:**
```bash
php artisan make:livewire Admin/ApplicationReview
```

---

#### AdministrativeSelection Component
**Purpose:** Administrative document review

**Features:**
- Application list with filters
- Document checklist
- CV preview
- Mark as complete/incomplete
- Bulk approve/reject
- Save filter criteria

**Command:**
```bash
php artisan make:livewire Admin/AdministrativeSelection
```

---

#### PsychotestManagement Component
**Purpose:** Manage psychotest invitations

**Features:**
- Send invitation (email/WhatsApp)
- Set test schedule
- Set expiry date
- Monitor ongoing tests (real-time)
- View results
- Set passing grade
- Auto pass/fail calculation

**Command:**
```bash
php artisan make:livewire Admin/PsychotestManagement
```

---

#### PsychotestMonitor Component
**Purpose:** Real-time psychotest monitoring

**Features:**
- List of ongoing tests
- Last activity timestamp
- Test progress
- Alert for inactive tests
- Auto-refresh

**Command:**
```bash
php artisan make:livewire Admin/PsychotestMonitor
```

---

#### InterviewScheduling Component
**Purpose:** Schedule interviews

**Features:**
- Calendar view
- Select interviewer(s)
- Set date/time
- Choose mode (onsite/zoom/phone)
- Send invitation
- Generate ICS file
- Set reminder

**Command:**
```bash
php artisan make:livewire Admin/InterviewScheduling
```

---

#### InterviewAssessment Component
**Purpose:** Multi-assessor interview rating

**Features:**
- Assessment criteria (1-10 scale)
- Qualitative feedback
- Strengths/weaknesses
- Final decision
- View other assessors' ratings
- Average score calculation

**Command:**
```bash
php artisan make:livewire Admin/InterviewAssessment
```

---

#### BackgroundCheckManagement Component
**Purpose:** Manage background check forms

**Features:**
- Send form to referee
- Auto-send toggle
- Set expiry date
- Send reminders
- View responses
- Approve/reject

**Command:**
```bash
php artisan make:livewire Admin/BackgroundCheckManagement
```

---

#### MedicalCheckupImport Component
**Purpose:** Bulk import MCU results

**Features:**
- Excel file upload
- Preview data
- Validate data
- Import progress bar
- Error handling
- Download template

**Command:**
```bash
php artisan make:livewire Admin/MedicalCheckupImport
```

---

#### HiringApproval Component
**Purpose:** Final hiring approval

**Features:**
- Candidate details
- All stage results
- Set join date
- Set briefing date
- Generate offer letter (PDF)
- Send offer
- Export to Realta

**Command:**
```bash
php artisan make:livewire Admin/HiringApproval
```

---

#### CandidatePoolManagement Component
**Purpose:** Manage candidate pool

**Features:**
- Add candidate manually
- Upload CV
- Set source (referral, walk-in, headhunt)
- Tag candidates
- Convert to applicant
- Search and filter

**Command:**
```bash
php artisan make:livewire Admin/CandidatePoolManagement
```

---

#### RecruitmentAnalytics Component
**Purpose:** Analytics dashboard

**Features:**
- Funnel chart (conversion rates)
- Monthly metrics
- Education breakdown (charts)
- Source tracking
- Job-specific analytics
- Export reports

**Command:**
```bash
php artisan make:livewire Admin/RecruitmentAnalytics
```

---

#### NotificationTemplateEditor Component
**Purpose:** Edit email/WhatsApp templates

**Features:**
- Template list
- WYSIWYG editor for email
- Text editor for WhatsApp
- Variable picker
- Preview
- Set active/default
- Test send

**Command:**
```bash
php artisan make:livewire Admin/NotificationTemplateEditor
```

---

#### JobManagement Component
**Purpose:** Create and manage job vacancies

**Features:**
- Create job form
- Edit job details
- Set publish/end date
- Set selection type
- Skills required (tags)
- Publish/unpublish
- Clone job

**Command:**
```bash
php artisan make:livewire Admin/JobManagement
```

---

### 3. Shared Components

#### FileUpload Component
**Purpose:** Reusable file upload with progress

**Features:**
- Drag & drop
- Progress bar
- File validation
- Preview
- Multiple files
- Delete uploaded file

**Command:**
```bash
php artisan make:livewire Components/FileUpload
```

---

#### NotificationBell Component
**Purpose:** Real-time notifications

**Features:**
- Notification count badge
- Dropdown list
- Mark as read
- View all link
- Auto-refresh

**Command:**
```bash
php artisan make:livewire Components/NotificationBell
```

---

#### SearchBar Component
**Purpose:** Global search with Scout

**Features:**
- Search input
- Live search results
- Category filter
- Keyboard navigation
- Recent searches

**Command:**
```bash
php artisan make:livewire Components/SearchBar
```

---

#### DataTable Component
**Purpose:** Reusable data table

**Features:**
- Sortable columns
- Filterable
- Pagination
- Bulk actions
- Export
- Column visibility toggle

**Command:**
```bash
php artisan make:livewire Components/DataTable
```

---

#### Modal Component
**Purpose:** Reusable modal dialog

**Features:**
- Open/close
- Size options
- Confirm dialog
- Form modal
- Loading state

**Command:**
```bash
php artisan make:livewire Components/Modal
```

---

## 🚀 Create All Components Script

```bash
# Public/Applicant Components
php artisan make:livewire JobList
php artisan make:livewire JobDetail
php artisan make:livewire ApplicationForm
php artisan make:livewire ApplicantDashboard
php artisan make:livewire ProfileCompletion
php artisan make:livewire InterviewConfirmation

# Admin/HR Components
php artisan make:livewire Admin/ApplicationReview
php artisan make:livewire Admin/AdministrativeSelection
php artisan make:livewire Admin/PsychotestManagement
php artisan make:livewire Admin/PsychotestMonitor
php artisan make:livewire Admin/InterviewScheduling
php artisan make:livewire Admin/InterviewAssessment
php artisan make:livewire Admin/BackgroundCheckManagement
php artisan make:livewire Admin/MedicalCheckupImport
php artisan make:livewire Admin/HiringApproval
php artisan make:livewire Admin/CandidatePoolManagement
php artisan make:livewire Admin/RecruitmentAnalytics
php artisan make:livewire Admin/NotificationTemplateEditor
php artisan make:livewire Admin/JobManagement

# Shared Components
php artisan make:livewire Components/FileUpload
php artisan make:livewire Components/NotificationBell
php artisan make:livewire Components/SearchBar
php artisan make:livewire Components/DataTable
php artisan make:livewire Components/Modal
```

---

## 📝 Livewire Best Practices

### 1. Use Wire:model for Two-way Binding
```php
<input type="text" wire:model="search">
```

### 2. Use Wire:loading for Loading States
```php
<button wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading>Saving...</span>
</button>
```

### 3. Use Wire:poll for Auto-refresh
```php
<div wire:poll.5s>
    <!-- Content refreshes every 5 seconds -->
</div>
```

### 4. Use Wire:dirty for Unsaved Changes
```php
<input wire:model="name" wire:dirty.class="border-yellow-500">
```

### 5. File Uploads
```php
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;
    
    public $photo;
    
    public function save()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);
        
        $this->photo->store('photos');
    }
}
```

### 6. Pagination
```php
use Livewire\WithPagination;

class JobList extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.job-list', [
            'jobs' => Job::paginate(10)
        ]);
    }
}
```

---

## 🎨 UI Framework

**Recommended:** TailwindCSS + DaisyUI or Flowbite

**Why:**
- No CDN required (build locally)
- Modern components
- Dark mode support
- Responsive
- Customizable

**Install:**
```bash
npm install -D tailwindcss postcss autoprefixer
npm install -D daisyui
# or
npm install flowbite
```

---

## ✅ Component Checklist

After creating components:

- [ ] All 20+ components created
- [ ] File upload component working
- [ ] Real-time features tested
- [ ] Modals working
- [ ] Forms validated
- [ ] Pagination working
- [ ] Loading states implemented
- [ ] Error handling added
- [ ] Mobile responsive
- [ ] Dark mode support (optional)

---

**Plan Version:** 1.0  
**Last Updated:** 2025-10-21  
**Status:** Ready to Implement
