# Quick Start Guide - PT Aisin Indonesia Recruitment System v2.0

## ✅ Database Migration Completed

Your PostgreSQL database has been successfully migrated and updated to v2.0 with **46 tables** ready for the recruitment system.

---

## 🚀 What's Next?

### Step 1: Install Required Packages

```bash
# Install Spatie Permission for RBAC
composer require spatie/laravel-permission

# Install Spatie Activity Log for audit trail
composer require spatie/laravel-activitylog

# Optional: Install Media Library for file handling
composer require spatie/laravel-medialibrary
```

### Step 2: Publish Package Configurations

```bash
# Publish permission config
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Publish activity log config
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider"
```

### Step 3: Create Seeders for Initial Data

Create role and permission seeder:

```bash
php artisan make:seeder RolePermissionSeeder
```

Example seeder content:
```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Create roles
$applicant = Role::create(['name' => 'applicant']);
$hrRecruiter = Role::create(['name' => 'hr_recruiter']);
$interviewer = Role::create(['name' => 'interviewer']);
$admin = Role::create(['name' => 'admin']);

// Create permissions
Permission::create(['name' => 'view-jobs']);
Permission::create(['name' => 'apply-job']);
Permission::create(['name' => 'manage-applications']);
Permission::create(['name' => 'conduct-interview']);
Permission::create(['name' => 'manage-users']);

// Assign permissions to roles
$applicant->givePermissionTo(['view-jobs', 'apply-job']);
$hrRecruiter->givePermissionTo(['view-jobs', 'manage-applications']);
$interviewer->givePermissionTo(['conduct-interview']);
$admin->givePermissionTo(Permission::all());
```

Run the seeder:
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Step 4: Create Sample Job Postings

```bash
php artisan make:seeder JobSeeder
```

Example:
```php
use App\Models\Job;

Job::create([
    'code' => 'JOB-2025-001',
    'title' => 'Production Operator',
    'slug' => 'production-operator',
    'department' => 'Production',
    'location' => 'Karawang',
    'employment_type' => 'full_time',
    'description' => 'Looking for production operators...',
    'requirements' => 'Min. SMA/SMK, Age 18-30...',
    'status' => 'open',
    'posted_at' => now(),
    'closing_at' => now()->addDays(30),
]);
```

---

## 📊 Database Overview

### Current Status (v2.0)
- **Total Tables:** 46 (+4 new)
- **Total Rows:** 0 (empty, ready for data)
- **Database Size:** 1.49 MB
- **Migrations:** 34 (21 initial + 13 updates)

### Table Categories

1. **Authentication** (1): `users`
2. **RBAC** (5): `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`
3. **Applicant Profile** (17): Identity, Education, Family, Work, Skills, etc.
4. **Jobs & Applications** (3): `jobs`, `applications`, `application_stage_histories`
5. **Recruitment Process** (6): Administrative, Psychotest, Interview, BGC, MCU, Hiring
6. **NEW v2.0** (4): `interview_assessments`, `candidate_pool`, `recruitment_analytics`, `notification_templates`
7. **Supporting** (9): Attachments, Notifications, Activity Log, Cache, etc.

---

## 🔍 Useful Commands

### Database Information
```bash
# Show database overview
php artisan db:show

# Show database with row counts
php artisan db:show --counts

# View specific table structure
php artisan db:table users
php artisan db:table applications
php artisan db:table jobs

# Check migration status
php artisan migrate:status
```

### Testing Database Connection
```bash
# Open tinker
php artisan tinker

# Test queries
>>> \App\Models\User::count()
>>> DB::table('jobs')->count()
```

---

## 📁 Important Files

### Documentation
- `DATABASE_SCHEMA.md` - Complete database schema documentation
- `MIGRATION_SUMMARY.md` - Migration execution summary
- `QUICK_START.md` - This file

### SQL Reference
- `database/schema_reference.sql` - Common SQL queries

### Migrations
All migration files are in `database/migrations/` with prefix `2025_10_21_*`

---

## 🎯 Recruitment Pipeline Flow

```
1. Applied
   ↓
2. Administrative Selection (document review)
   ↓
3. Psychotest (IQ, Personality, Skills)
   ↓
4. Interview (HR, User, Technical)
   ↓
5. Background Check (referee verification)
   ↓
6. Medical Checkup (health examination)
   ↓
7. Hiring Approval (offer letter)
   ↓
8. Hired ✅
```

Each stage is tracked in dedicated tables with status, timestamps, and results.

---

## 📝 Applicant Profile Sections

### Section A: Identity
- Personal info, contact, address, NIK, driving license, physical attributes

### Section B: Education
- Formal education (SD, SLTP, SMA/SMK)
- Non-formal education (courses, training)
- Language skills
- Organization experience

### Section C: Family
- Marital status
- Spouse and children
- Family members (parents, siblings)

### Section D: Work History
- Previous employment
- Position, salary, duration

### Section E: Interest & Motivation
- Skills and proficiency
- Motivation questions
- Department preferences (top 3)

### Section F: Background Check
- Referee contacts

### Section G: Others
- Previous Aisin applications
- Hobbies and free time
- Strengths and weaknesses
- Medical history

---

## 🔐 Security Checklist

- [ ] Configure `.env` with secure database credentials
- [ ] Set up proper RBAC roles and permissions
- [ ] Implement email verification for applicants
- [ ] Add file upload validation for attachments
- [ ] Enable CSRF protection on forms
- [ ] Implement rate limiting on API endpoints
- [ ] Set up backup strategy for database
- [ ] Configure SSL/TLS for production

---

## 🛠️ Development Workflow

### 1. Create Models
```bash
php artisan make:model ApplicantIdentity
php artisan make:model Application
php artisan make:model Job
# ... create all models
```

### 2. Define Relationships in Models
Example for User model:
```php
public function applicantIdentity()
{
    return $this->hasOne(ApplicantIdentity::class);
}

public function applications()
{
    return $this->hasMany(Application::class);
}

public function formalEducations()
{
    return $this->hasMany(FormalEducation::class);
}
```

### 3. Create Controllers
```bash
php artisan make:controller JobController --resource
php artisan make:controller ApplicationController --resource
php artisan make:controller ApplicantProfileController
```

### 4. Define Routes
```php
// Public routes
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{job}', [JobController::class, 'show']);

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store']);
    Route::get('/my-applications', [ApplicationController::class, 'index']);
});

// Admin routes
Route::middleware(['auth', 'role:admin|hr_recruiter'])->group(function () {
    Route::resource('admin/jobs', JobController::class);
    Route::resource('admin/applications', ApplicationController::class);
});
```

### 5. Create Views
```bash
# Job listings
resources/views/jobs/index.blade.php
resources/views/jobs/show.blade.php

# Application form
resources/views/applications/create.blade.php

# Admin dashboard
resources/views/admin/dashboard.blade.php
resources/views/admin/applications/index.blade.php
```

---

## 📞 Support & Resources

### Laravel Documentation
- https://laravel.com/docs

### Spatie Packages
- Permission: https://spatie.be/docs/laravel-permission
- Activity Log: https://spatie.be/docs/laravel-activitylog
- Media Library: https://spatie.be/docs/laravel-medialibrary

### PostgreSQL Documentation
- https://www.postgresql.org/docs/

---

## ✅ Verification Checklist

### v1.0 (Completed)
- [x] Database created (erp_system)
- [x] All 42 tables created successfully
- [x] Foreign key constraints applied
- [x] Indexes created for performance
- [x] Migration files organized
- [x] Documentation generated

### v2.0 (Completed)
- [x] 4 new tables created (interview_assessments, candidate_pool, recruitment_analytics, notification_templates)
- [x] 9 tables updated with new fields
- [x] NIK verification fields added
- [x] Disability screening fields added
- [x] Profile completion tracking added
- [x] PDP consent fields added
- [x] Real-time monitoring fields added
- [x] Interview confirmation system added
- [x] Auto-send BGC fields added
- [x] Bulk MCU import fields added
- [x] Join date & export fields added
- [x] Documentation updated to v2.0

### Next Steps
- [ ] Spatie packages installed
- [ ] Seeders created and run
- [ ] Models created with relationships (including 4 new models)
- [ ] Controllers and routes defined
- [ ] Views/frontend implemented
- [ ] Disdukcapil API integration
- [ ] Email/WhatsApp template management UI
- [ ] Analytics dashboard implementation

---

## 🆕 What's New in v2.0

### Enhanced Features
1. **NIK Verification** - Integration ready for Disdukcapil API
2. **Disability Screening** - Track disability status and colorblind conditions
3. **Profile Completion** - Real-time percentage indicator (0-100%)
4. **PDP Consent** - Personal Data Protection compliance tracking
5. **Real-time Monitoring** - Track psychotest progress and activity
6. **Interview Confirmation** - Candidate can confirm/decline with ICS calendar
7. **Multi-Assessor Rating** - Multiple interviewers can rate independently
8. **Auto-Send BGC** - Automated background check form distribution
9. **Bulk MCU Import** - Import medical checkup results from Excel
10. **Candidate Pool** - Manage referrals and walk-in candidates
11. **Analytics Dashboard** - Recruitment metrics and funnel analysis
12. **Template System** - Customizable email and WhatsApp notifications
13. **Realta Export** - Export hired candidates to Realta format

### New Models to Create
```bash
php artisan make:model InterviewAssessment
php artisan make:model CandidatePool
php artisan make:model RecruitmentAnalytic
php artisan make:model NotificationTemplate
```

---

**System Ready!** 🎉

Your recruitment system database is fully updated to v2.0 and ready for development. Follow the steps above to complete the application layer.

**Next immediate action:** Install Spatie packages and create seeders for roles/permissions.
