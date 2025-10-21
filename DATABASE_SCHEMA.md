# PT Aisin Indonesia - Recruitment System Database Schema v2.0

**Generated:** 2025-10-21 (Updated)  
**Database:** PostgreSQL  
**Total Tables:** 46

## Overview

Complete database schema for career portal and recruitment management system with the following features:

- ✅ Job vacancy posting & management
- ✅ Complete applicant profile (Sections A-G)
- ✅ Full recruitment pipeline (Admin → Psychotest → Interview → BGC → MCU → Hiring)
- ✅ Role-based access control (RBAC) using Spatie Permission
- ✅ File attachments (polymorphic)
- ✅ Activity logging & notifications
- ✅ **NEW:** NIK verification with Disdukcapil
- ✅ **NEW:** Disability/colorblind screening
- ✅ **NEW:** Profile completion indicator
- ✅ **NEW:** PDP (Personal Data Protection) consent
- ✅ **NEW:** Customizable email/WA templates
- ✅ **NEW:** Real-time psychotest monitoring
- ✅ **NEW:** Interview confirmation system
- ✅ **NEW:** Bulk MCU results import
- ✅ **NEW:** Candidate pool management
- ✅ **NEW:** Recruitment analytics dashboard
- ✅ **NEW:** Excel export to Realta format

---

## Database Structure

### 🔐 Core Authentication & Users

#### `users`
Core authentication table supporting both applicants and internal staff.

**Columns:**
- `id` (PK)
- `name`, `email` (unique), `password`
- `email_verified_at`, `remember_token`
- `created_at`, `updated_at`

---

### 👤 Section A: IDENTITAS (Identity)

#### `applicant_identities`
Complete applicant identity information (1:1 with users).

**Key Fields:**
- Personal: `full_name`, `birth_place`, `birth_date`, `gender`, `religion`
- Contact: `phone_number`, `email`, `parent_phone`
- Address: `address_ktp`, `address_domicile`
- ID: `national_id_number` (NIK/KTP - unique)
- **NEW - NIK Verification:** `nik_verified_at`, `birth_date_verified`
- **NEW - Disability Screening:** `has_disability`, `disability_type`, `is_colorblind`
- **NEW - Vision:** `has_vision_correction`, `vision_details`
- License: `driving_license_types` (JSON array), `driving_license_number`
- Physical: `height_cm`, `weight_kg`, `blood_type`
- Size: `shirt_size`, `pants_size`, `shoe_size`
- Photo: `photo_path`

---

### 📚 Section B: PENDIDIKAN (Education)

#### `formal_educations`
Formal education history (minimum 3 records: SD, SLTP, SMA/SMK).

**Fields:**
- `level` (SD, SLTP, SMA, SMK)
- `school_name`, `major`, `graduation_year`, `location`
- `math_avg_semester`, `math_un_score`

#### `non_formal_educations`
Non-formal education (courses, training, certifications).

**Fields:**
- `course_name`, `location`
- `period_start`, `period_end`

#### `language_skills`
Foreign language proficiency.

**Fields:**
- `language_name`
- `writing_skill`, `reading_skill`, `grammar_skill` (baik/kurang)

#### `organization_experiences`
Organization & extracurricular experience.

**Fields:**
- `organization_name`, `position`, `location`
- `period_start`, `period_end`

---

### 👨‍👩‍👧‍👦 Section C: LINGKUNGAN KELUARGA (Family)

#### `marital_statuses`
Marital status (KTP vs actual) - 1:1 with users.

**Fields:**
- `status_ktp`, `status_actual` (single, engaged, married, divorced)
- `status_date`

#### `spouses_and_children`
Spouse and children information.

**Fields:**
- `relation_type` (spouse, child1, child2, ...)
- `name`, `gender`, `birth_place`, `birth_date`
- `education`, `occupation`

#### `family_members`
Family tree (parents, siblings including applicant).

**Fields:**
- `relation_type` (father, mother, child1, child2, ...)
- `name`, `gender`, `birth_place`, `birth_date`
- `education`, `occupation`

---

### 💼 Section D: RIWAYAT PEKERJAAN (Work History)

#### `work_experiences`
Previous work experience.

**Fields:**
- `company_name`, `position`, `salary`
- `period_start`, `period_end`
- `reason_for_leaving`

---

### 🎯 Section E: MINAT & KONSEP PRIBADI (Interest)

#### `applicant_skills`
Technical and soft skills.

**Fields:**
- `skill_name` (welding, forklift, ms_office, autocad, etc.)
- `proficiency_level` (beginner, intermediate, advanced, expert)

#### `applicant_motivations`
Motivation and personal concept questions - 1:1 with users.

**Fields:**
- `q2_motivation` - Apa yang mendorong anda ingin bekerja?
- `q3_why_company` - Mengapa ingin bekerja di perusahaan kami?
- `q4_expected_salary` - Gaji yang diinginkan
- `q5_available_start_date` - Kapan bisa mulai bekerja
- `q6_has_referral`, `q6_referral_name`, `q6_referral_relation`

#### `department_preferences`
Top 3 department preferences (ordered by priority).

**Fields:**
- `department_name`
- `priority_order` (1, 2, or 3)

---

### 🔍 Section F: BACKGROUND CHECKING

#### `background_check_referees`
References for background verification.

**Fields:**
- `referee_name`, `department_position`, `company_name`
- `whatsapp_number`, `email`

---

### 📝 Section G: LAIN-LAIN (Others)

#### `previous_applications`
Previous application history to Aisin.

**Fields:**
- `organizer`, `process_stage`, `date`, `location`

#### `applicant_hobbies`
Hobbies and free time activities - 1:1 with users.

**Fields:**
- `hobbies` (text or JSON array)
- `free_time_activity`

#### `applicant_strengths_weaknesses`
Strong points and weak points (minimum 3 each).

**Fields:**
- `type` (strength or weakness)
- `description`
- `order_number`

#### `medical_histories`
Medical history (chronic diseases).

**Fields:**
- `disease_name`
- `is_active` (ya, tidak, sudah_tidak)
- `suffered_since`

---

## 📋 Jobs & Application Process

### `jobs`
Job vacancy postings.

**Fields:**
- `code` (unique), `title`, `slug` (unique)
- **NEW - General Info:** `publish_date`, `end_date`
- **NEW - Vacancy Info:** `vacancy_title`, `position`, `education_level`, `category`, `function`, `company`
- **NEW - Job Description:** `skills_required` (JSON), `total_needed`
- **NEW - Selection Type:** `selection_type` (operator_smk, staff_d3s1)
- `department`, `location`, `employment_type`, `seniority`
- `description`, `requirements`, `responsibilities`
- `salary_range`
- `hiring_manager_id` (FK to users)
- `posted_at`, `closing_at`
- `status` (draft, open, closed)

### `applications`
Job applications submitted by users.

**Fields:**
- `job_id`, `user_id`
- `application_number` (unique: APP-YYYYMMDD-XXX)
- `current_stage` (applied, administrative, psychotest, interview, background_check, medical_checkup, hiring_approval, rejected, hired)
- **NEW - Profile Completion:** `profile_completion_percentage` (0-100%)
- **NEW - PDP Consent:** `pdp_consent_given`, `pdp_consent_at`
- `applied_at`, `hired_at`, `rejected_at`
- `rejection_reason`, `source`, `cover_letter`, `notes`

### `application_stage_histories`
Audit trail of application stage changes.

**Fields:**
- `application_id`, `from_stage`, `to_stage`
- `changed_by`, `notes`, `changed_at`

---

## 🔄 Recruitment Process Stages

### `administrative_selections`
Administrative document review stage - 1:1 with applications.

**Fields:**
- `application_id`, `reviewed_by`
- `status` (pending, passed, failed)
- **NEW - Filter & Sort:** `filter_criteria` (JSON), `sort_by`
- `cv_complete`, `documents_valid`
- `reviewed_at`

### `psychotests`
Psychological and skills testing.

**Fields:**
- `application_id`, `test_type` (WPT, Army_Alpha, Papikostick, SSCT, Kraeplin, IQ, Personality, Work_Behavior)
- `invitation_token`, `invitation_sent_at`, `invitation_sent_by`
- `test_scheduled_at`, `test_completed_at`, `test_location`
- **NEW - Monitoring:** `test_expiry_at`, `test_started_at`, `test_last_activity_at`, `is_currently_taking`
- **NEW - Auto Pass/Fail:** `passing_grade`, `is_passed`
- `result_score` (JSON), `result_file_path`
- `status` (invited, scheduled, completed, failed, cancelled)

### `interviews`
Interview scheduling and assessment.

**Fields:**
- `application_id`, `interview_type` (hr, user, technical)
- `interviewer_id`, `scheduled_at`, `scheduled_by`
- `mode` (onsite, zoom, phone)
- `location_or_link`, `duration_minutes`
- **NEW - Confirmation:** `candidate_confirmed`, `candidate_declined`, `decline_reason`, `confirmed_at`
- **NEW - Calendar:** `ics_file_path`
- **NEW - Reminder:** `reminder_sent_at`
- `status` (scheduled, completed, cancelled, no_show)
- `assessment_scores` (JSON - deprecated, use interview_assessments table)
- `completed_at`, `result` (passed, failed, pending)

### `interview_assessments` **NEW TABLE**
Multi-user interview rating system.

**Fields:**
- `interview_id`, `assessor_id`
- Assessment Criteria: `technical_competence`, `communication_skills`, `problem_solving`, `cultural_fit`, `attitude`, `overall_impression` (1-10)
- Qualitative: `strengths`, `weaknesses`, `recommendation`, `final_decision`
- `assessed_at`

### `background_checks`
Background verification via referees.

**Fields:**
- `application_id`
- `referee_name`, `referee_position`, `referee_company`, `referee_email`, `referee_phone`
- `form_token`, `form_sent_at`, `form_sent_by`, `form_completed_at`
- **NEW - Auto-Send:** `auto_send_enabled`, `link_expiry_date`, `reminder_count`, `last_reminder_sent_at`
- `responses` (JSON)
- `status` (pending, sent, completed, failed)
- `result` (passed, failed, pending)

### `medical_checkups`
Medical checkup stage - 1:1 with applications.

**Fields:**
- `application_id`
- **NEW - Scheduling:** `mcu_date`, `mcu_location`, `mcu_requirements`, `invitation_sent_at`
- `scheduled_at`, `scheduled_by`
- `clinic_name`, `clinic_address`
- `result_file_path`, `result_data` (JSON)
- **NEW - Bulk Import:** `imported_from_excel`, `excel_row_number`
- `status` (scheduled, completed, failed)
- `result` (fit, unfit, pending)
- `completed_at`

### `hiring_approvals`
Final hiring approval and offer letter - 1:1 with applications.

**Fields:**
- `application_id`
- `requested_by`, `approved_by`
- **NEW - Approval Tracking:** `approval_requested_to`, `approval_document_path`
- `requested_at`, `approved_at`, `rejected_at`
- `status` (pending, approved, rejected)
- `offer_letter_path`, `offer_sent_at`
- `salary_offered`
- **NEW - Join & Briefing:** `join_date`, `briefing_date`
- **NEW - Export:** `exported_to_realta_format`, `exported_at`, `exported_by`

---

## 🆕 NEW TABLES (v2.0)

### `candidate_pool` **NEW**
Manual candidate input from referrals, walk-ins, headhunting.

**Fields:**
- Basic Info: `full_name`, `email`, `phone_number`, `national_id_number`
- Source: `source_type`, `referred_by`, `referred_by_user_id`
- Quick Profile: `education_level`, `latest_school`, `latest_position`, `latest_company`
- CV: `cv_path`
- Conversion: `is_converted_to_user`, `converted_user_id`
- Tagging: `tags` (JSON)
- `created_by`

### `recruitment_analytics` **NEW**
Dashboard analytics and metrics.

**Fields:**
- `job_id`, `month` (YYYY-MM-01)
- Metrics: `total_applicants`, `passed_administrative`, `passed_psychotest`, `passed_hr_interview`, `passed_user_interview`, `passed_background_check`, `passed_medical_checkup`, `reached_offering`, `hired_count`
- Education Breakdown: `applicants_by_school` (JSON), `applicants_by_university` (JSON)
- Source Tracking: `applicants_by_source` (JSON)

### `notification_templates` **NEW**
Customizable email and WhatsApp templates.

**Fields:**
- `name`, `type` (email, whatsapp, both), `stage`
- Email: `email_subject`, `email_body` (HTML/Markdown)
- WhatsApp: `whatsapp_message`
- Variables: `available_variables` (JSON) - {{name}}, {{date}}, {{link}}, etc.
- Status: `is_active`, `is_default`
- `created_by`, `updated_by`

---

## 🔧 Supporting Tables

### `attachments`
Polymorphic file attachments (Spatie MediaLibrary compatible).

**Fields:**
- `attachable_type`, `attachable_id` (polymorphic)
- `collection_name` (resume, cv, photo, certificate, etc.)
- `disk`, `file_path`, `file_name`, `mime_type`, `size_bytes`
- `uploaded_by`

### `notifications`
Laravel default notifications table.

**Fields:**
- `id` (UUID), `type`
- `notifiable_type`, `notifiable_id` (polymorphic)
- `data`, `read_at`

### `activity_log`
Spatie Activity Log - audit trail.

**Fields:**
- `log_name`, `description`
- `subject_type`, `subject_id` (polymorphic)
- `causer_type`, `causer_id` (polymorphic)
- `properties` (JSON), `event`, `batch_uuid`

---

## 🔐 RBAC (Role-Based Access Control)

Using **Spatie Laravel Permission** package.

### `roles`
Roles (applicant, hr_recruitment, interviewer, etc.)

### `permissions`
Permissions (view-jobs, update-applications, etc.)

### `model_has_roles`
Many-to-Many: Users ↔ Roles

### `model_has_permissions`
Direct permission assignment to users

### `role_has_permissions`
Many-to-Many: Roles ↔ Permissions

---

## 📊 Relationship Summary

### 1:1 (One-to-One)
- `users` → `applicant_identities`
- `users` → `marital_statuses`
- `users` → `applicant_motivations`
- `users` → `applicant_hobbies`
- `applications` → `administrative_selections`
- `applications` → `medical_checkups`
- `applications` → `hiring_approvals`

### 1:N (One-to-Many)
- `users` → `formal_educations` (min 3)
- `users` → `non_formal_educations`
- `users` → `language_skills`
- `users` → `organization_experiences`
- `users` → `spouses_and_children`
- `users` → `family_members`
- `users` → `work_experiences`
- `users` → `applicant_skills`
- `users` → `department_preferences` (max 3)
- `users` → `background_check_referees`
- `users` → `previous_applications`
- `users` → `applicant_strengths_weaknesses` (min 3 each type)
- `users` → `medical_histories`
- `users` → `applications`
- `users` → `candidate_pool` (as creator) **NEW**
- `jobs` → `applications`
- `jobs` → `recruitment_analytics` **NEW**
- `applications` → `application_stage_histories`
- `applications` → `psychotests`
- `applications` → `interviews`
- `applications` → `background_checks`
- `interviews` → `interview_assessments` **NEW**

### N:M (Many-to-Many)
- `users` ↔ `roles` (via `model_has_roles`)
- `users` ↔ `permissions` (via `model_has_permissions`)
- `roles` ↔ `permissions` (via `role_has_permissions`)

### Polymorphic
- `attachments` → morphTo (users, applications, psychotests, etc.)
- `notifications` → morphTo (users)
- `activity_log` → morphTo (any model)

---

## 🗑️ Cascade Rules

### CASCADE DELETE
All user-related tables cascade delete when user is deleted.
All application-related tables cascade delete when application is deleted.

### SET NULL
- `interviewer_id`, `hiring_manager_id` → SET NULL when user deleted

---

## 📦 Laravel Packages Used

1. **Spatie Laravel Permission** - RBAC system
2. **Spatie Laravel Activity Log** - Audit trail
3. **Spatie Laravel MediaLibrary** (compatible) - File attachments

---

## 🚀 Migration Files

All migration files are located in `database/migrations/`:

### Initial Schema (v1.0)
1. `2025_10_21_000000_drop_all_existing_tables.php` - Drop old schema
2. `2025_10_21_000001_create_users_table.php` - Core users
3. `2025_10_21_000002_create_permission_tables.php` - RBAC
4. `2025_10_21_000003_create_applicant_identities_table.php` - Section A
5. `2025_10_21_000004_create_education_tables.php` - Section B
6. `2025_10_21_000005_create_family_tables.php` - Section C
7. `2025_10_21_000006_create_work_experiences_table.php` - Section D
8. `2025_10_21_000007_create_interest_motivation_tables.php` - Section E
9. `2025_10_21_000008_create_background_and_other_tables.php` - Sections F & G
10. `2025_10_21_000009_create_jobs_and_applications_tables.php` - Jobs & Applications
11. `2025_10_21_000010_create_recruitment_process_tables.php` - Recruitment stages
12. `2025_10_21_000011_create_supporting_tables.php` - Supporting tables

### Updates (v2.0)
13. `2025_10_21_120000_update_applicant_identities_add_verification_fields.php` - NIK verification, disability screening
14. `2025_10_21_120001_update_jobs_table_for_vacancy_management.php` - Vacancy management fields
15. `2025_10_21_120002_update_applications_add_profile_and_pdp.php` - Profile completion, PDP consent
16. `2025_10_21_120003_update_administrative_selections_add_filters.php` - Filter & sort criteria
17. `2025_10_21_120004_update_psychotests_add_monitoring_fields.php` - Real-time monitoring
18. `2025_10_21_120005_update_interviews_add_confirmation_system.php` - Confirmation system
19. `2025_10_21_120006_create_interview_assessments_table.php` - Multi-user assessments
20. `2025_10_21_120007_update_background_checks_add_auto_send.php` - Auto-send features
21. `2025_10_21_120008_update_medical_checkups_add_bulk_import.php` - Bulk import
22. `2025_10_21_120009_update_hiring_approvals_add_join_and_export.php` - Join date, export
23. `2025_10_21_120010_create_candidate_pool_table.php` - Candidate pool
24. `2025_10_21_120011_create_recruitment_analytics_table.php` - Analytics
25. `2025_10_21_120012_create_notification_templates_table.php` - Email/WA templates

---

## 📝 Notes

- All timestamps use PostgreSQL `timestamp(0) without time zone`
- JSON fields are used for flexible data structures (scores, responses, etc.)
- Unique constraints ensure data integrity
- Comprehensive indexing for query performance
- Foreign key constraints with appropriate cascade rules

---

## 🆕 What's New in v2.0

### Enhanced Features
1. **NIK Verification** - Integration with Disdukcapil API for identity verification
2. **Disability Screening** - Track disability status and colorblind conditions
3. **Profile Completion** - Real-time percentage indicator for applicant profiles
4. **PDP Consent** - Personal Data Protection compliance tracking
5. **Real-time Monitoring** - Track psychotest progress and activity
6. **Interview Confirmation** - Candidate can confirm/decline with ICS calendar
7. **Multi-Assessor Rating** - Multiple interviewers can rate candidates independently
8. **Auto-Send BGC** - Automated background check form distribution
9. **Bulk MCU Import** - Import medical checkup results from Excel
10. **Candidate Pool** - Manage referrals and walk-in candidates
11. **Analytics Dashboard** - Recruitment metrics and funnel analysis
12. **Template System** - Customizable email and WhatsApp notifications
13. **Realta Export** - Export hired candidates to Realta format

### New Tables (4)
- `interview_assessments` - Multi-user interview rating
- `candidate_pool` - Manual candidate management
- `recruitment_analytics` - Dashboard metrics
- `notification_templates` - Email/WA templates

### Updated Tables (9)
- `applicant_identities` - +7 fields (verification, disability)
- `jobs` - +11 fields (vacancy management)
- `applications` - +3 fields (profile, PDP)
- `administrative_selections` - +2 fields (filters)
- `psychotests` - +6 fields (monitoring)
- `interviews` - +6 fields (confirmation)
- `background_checks` - +4 fields (auto-send)
- `medical_checkups` - +6 fields (bulk import)
- `hiring_approvals` - +7 fields (join, export)

---

**Author:** @pradityabyan  
**Version:** 2.0  
**Last Updated:** 2025-10-21 12:50 PM
