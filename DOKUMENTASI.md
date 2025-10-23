# 📚 DOKUMENTASI ERP RECRUITMENT SYSTEM

## 🎯 Overview
Sistem ERP Recruitment berbasis Laravel 12 + Livewire untuk mengelola proses rekrutmen karyawan dari aplikasi hingga hiring.

---

## 🚀 Tech Stack
- **Framework:** Laravel 12.34.0
- **PHP:** 8.3.26
- **Frontend:** Livewire 3.x, TailwindCSS
- **Database:** PostgreSQL
- **Authentication:** Laravel Breeze
- **Permissions:** Spatie Laravel Permission

---

## 👥 User Roles

### 1. **Applicant (Pelamar)**
- Register & Login
- Complete profile (7 sections)
- Apply for jobs
- Track application status
- View offer letter

### 2. **HRD (HR Recruiter)**
- Manage job postings
- View all applications
- Screen candidates
- Schedule interviews
- Send offer letters

### 3. **Interviewer**
- View assigned interviews
- Conduct assessments
- Submit interview results

### 4. **Manager**
- Approve/reject candidates
- View hiring reports

### 5. **Admin**
- Full system access
- User management
- System configuration

---

## 📋 Applicant Profile Completion (7 Sections)

### **A. Identitas**
**Required Fields:**
- Nama Lengkap *
- Tempat & Tanggal Lahir *
- Nomor KTP (16 digit) *
- Nomor HP *
- Alamat KTP *
- Alamat Domisili *
- Email *
- Agama *
- Jenis Kelamin *

**Optional Fields:**
- SIM (A/B/C)
- Nomor SIM
- No HP Orang Tua
- Golongan Darah
- Tinggi & Berat Badan
- Ukuran Baju, Celana, Sepatu

**Model:** `ApplicantIdentity`
**Table:** `applicant_identities`

---

### **B. Pendidikan**

#### 1. Pendidikan Formal
- SD, SLTP, SMK/SMA
- Fields: Nama Sekolah, Jurusan, Tahun Lulus, Tempat, Rata-rata MTK, Nilai UN MTK

**Model:** `FormalEducation`
**Table:** `formal_educations`

#### 2. Pendidikan Non-Formal (Dynamic)
- Nama Kursus/Training
- Tempat, Periode, Keterangan

**Model:** `NonFormalEducation`
**Table:** `non_formal_educations`

#### 3. Bahasa Asing (Dynamic)
- Bahasa
- Kemampuan: Tulisan, Membaca, Tata Bahasa (Baik/Kurang)

**Model:** `LanguageSkill`
**Table:** `language_skills`

#### 4. Pengalaman Organisasi (Dynamic)
- Nama Organisasi/Ekstrakurikuler
- Tempat, Jabatan, Masa Jabatan

**Model:** `OrganizationExperience`
**Table:** `organization_experiences`

---

### **C. Keluarga**

#### 1. Status Pernikahan
- Status KTP & Aktual (Single/Tunangan/Menikah/Bercerai)
- Tanggal

**Model:** `MaritalStatus`
**Table:** `marital_statuses`

#### 2. Data Istri/Suami & Anak (Conditional - jika menikah)
- Nama, L/P, Tempat & Tgl Lahir, Pendidikan, Pekerjaan

**Model:** `SpousesAndChildren`
**Table:** `spouses_and_children`

#### 3. Susunan Keluarga
- Ayah, Ibu, Saudara Kandung
- Nama, L/P, Tempat & Tgl Lahir, Pendidikan, Pekerjaan

**Model:** `FamilyMember`
**Table:** `family_members`

---

### **D. Riwayat Pekerjaan**
- Nama Perusahaan
- Jabatan
- Gaji
- Periode Kerja
- Alasan Pindah

**Model:** `WorkExperience`
**Table:** `work_experiences`

---

### **E. Minat & Konsep Pribadi**
1. Keahlian yang dimiliki
2. Alasan ingin bekerja
3. Mengapa ingin bekerja di perusahaan ini
4. Ekspektasi Gaji *
5. Kapan bisa mulai bekerja *
6. Kenalan/Kerabat yang bekerja di perusahaan
7. Pilih 3 bidang pekerjaan (prioritas 1-3)

**Model:** `ApplicantMotivation`
**Table:** `applicant_motivations`

**Model:** `DepartmentPreference`
**Table:** `department_preferences`

---

### **F. Background Checking**
Minimum 3 referensi:
- Nama
- Bagian/Jabatan
- Perusahaan
- Nomor WA
- Email

**Model:** `ApplicantReference`
**Table:** `applicant_references`

---

### **G. Lain-lain**

#### 1. Riwayat Psychotest (Conditional)
- Penyelenggara, Proses, Waktu, Tempat

**Model:** `PreviousApplication`
**Table:** `previous_applications`

#### 2. Hobbies & Free Time
**Model:** `ApplicantHobby`
**Table:** `applicant_hobbies`

#### 3. Strengths & Weaknesses
- Minimal 3 kelebihan
- Minimal 3 kekurangan

**Model:** `ApplicantStrengthsWeaknesses`
**Table:** `applicant_strengths_weaknesses`

#### 4. Medical History (Conditional)
- Nama Penyakit, Status, Diderita Sejak, Keterangan

**Model:** `MedicalHistory`
**Table:** `medical_histories`

---

## 🔄 Application Flow

### **1. Job Application Process**
```
Browse Jobs → Job Detail → Apply
  ↓
Check Profile Completion
  ↓
< 100% → Redirect to Profile
  ↓
100% → Application Form
  ↓
Submit Application
  ↓
Create Application Record
  ↓
Generate Application Number (APP-YYYYMMDD-XXXX)
  ↓
Create Initial Stage (Application Review)
  ↓
Redirect to My Applications
```

### **2. Application Stages**
1. **Submitted** - Lamaran masuk
2. **Screening** - Seleksi administrasi
3. **Interview** - Wawancara
4. **Assessment** - Tes/Assessment
5. **Hired** - Diterima
6. **Rejected** - Ditolak

---

## 📁 File Structure

### **Livewire Components**

#### Applicant
```
app/Livewire/Applicant/
├── ProfileCompletion.php      # Main profile form (7 sections)
├── JobApplication.php          # Job application form
├── ApplicationTracker.php      # Track application progress
└── MyApplications.php          # List of user's applications
```

#### HRD
```
app/Livewire/Hrd/
├── Dashboard.php               # HRD dashboard with stats
├── JobsList.php                # Manage job postings
└── JobPosting.php              # Create/edit job
```

### **Views**

#### Profile Sections
```
resources/views/livewire/applicant/sections/
├── identity.blade.php          # Section A
├── education-full.blade.php    # Section B
├── family.blade.php            # Section C
├── work-history.blade.php      # Section D
├── motivation.blade.php        # Section E
├── references.blade.php        # Section F
└── others.blade.php            # Section G
```

### **Models**
```
app/Models/
├── User.php
├── ApplicantProfile.php
├── ApplicantIdentity.php
├── FormalEducation.php
├── NonFormalEducation.php
├── LanguageSkill.php
├── OrganizationExperience.php
├── MaritalStatus.php
├── SpousesAndChildren.php
├── FamilyMember.php
├── WorkExperience.php
├── ApplicantMotivation.php
├── DepartmentPreference.php
├── ApplicantReference.php
├── ApplicantHobby.php
├── ApplicantStrengthsWeaknesses.php
├── MedicalHistory.php
├── PreviousApplication.php
├── Job.php
└── Application.php
```

---

## 🛣️ Routes

### **Public Routes**
```php
GET  /                          # Landing page
GET  /jobs                      # Job listings
GET  /jobs/{id}                 # Job detail
GET  /signin                    # Login
GET  /signup                    # Register
```

### **Applicant Routes** (Auth Required)
```php
GET  /applicant/profile                 # Profile completion
GET  /applicant/jobs/{id}/apply         # Job application form
GET  /applicant/my-applications         # List applications
GET  /applicant/application/{id}        # Application tracker
```

### **HRD Routes** (Role: hr_recruiter|admin)
```php
GET  /hrd/dashboard                     # HRD dashboard
GET  /hrd/jobs                          # Manage jobs
GET  /hrd/jobs/create                   # Create job
GET  /hrd/jobs/{id}/edit                # Edit job
```

---

## 🎨 UI Components

### **Color Palette**
```css
Primary Blue:   #2563EB (blue-600)
Success Green:  #16A34A (green-600)
Warning Yellow: #CA8A04 (yellow-600)
Error Red:      #DC2626 (red-600)
Interview:      #9333EA (purple-600)

Text:
- Heading:      #111827 (gray-900)
- Body:         #374151 (gray-700)
- Secondary:    #6B7280 (gray-500)
```

### **Status Badges**
- **Submitted** → Blue
- **Screening** → Yellow
- **Interview** → Purple
- **Assessment** → Indigo
- **Hired** → Green
- **Rejected** → Red

---

## 🔧 Key Features

### **1. Profile Completion Tracking**
- Dynamic progress calculation (0-100%)
- Section-by-section validation
- Visual indicators (✓ complete, ⚠ incomplete)
- Auto-save functionality

### **2. Application Management**
- Application number generation
- Duplicate application prevention
- Profile completion check before apply
- Real-time status tracking

### **3. HRD Dashboard**
- Statistics cards (6 metrics)
- Advanced filters (search, status, job)
- Paginated applications table
- Quick actions

---

## 📊 Database Schema

### **Key Tables**

#### applicant_identities
```sql
- id, user_id (FK)
- full_name, birth_place, birth_date
- national_id_number (16 digits, unique)
- phone_number, parent_phone
- address_ktp, address_domicile
- email, religion, gender
- blood_type, height_cm, weight_kg
- shirt_size, pants_size, shoe_size
- driving_license_types, driving_license_number
```

#### applications
```sql
- id, user_id (FK), job_id (FK)
- application_number (unique)
- cover_letter, expected_salary
- available_start_date
- status, applied_at
```

#### jobs
```sql
- id, title, code
- department, location
- employment_type, selection_type
- salary_min, salary_max
- description, requirements
- status, closing_at
```

---

## 🚨 Validation Rules

### **Identity Section**
```php
'identity_full_name' => 'required|min:3'
'identity_birth_place' => 'required'
'identity_birth_date' => 'required|date'
'identity_national_id_number' => 'required|numeric|digits:16'
'identity_phone_number' => 'required|min:10'
'identity_address_ktp' => 'required|min:10'
'identity_address_domicile' => 'required|min:10'
'identity_email' => 'required|email'
'identity_religion' => 'required'
'identity_gender' => 'required|in:L,P'
```

### **Job Application**
```php
'coverLetter' => 'required|min:100'
'expectedSalary' => 'nullable|numeric|min:0'
'availableStartDate' => 'required|date|after:today'
```

---

## 🔐 Security Features
- CSRF Protection (Laravel default)
- Role-based access control (Spatie Permission)
- Email verification (optional)
- Password hashing (bcrypt)
- SQL injection prevention (Eloquent ORM)

---

## 📝 TODO / Future Enhancements
- [ ] Email notifications (application status updates)
- [ ] Interview scheduling system
- [ ] Psychotest integration
- [ ] Medical checkup tracking
- [ ] Offer letter generation (PDF)
- [ ] Background check automation
- [ ] Analytics & reporting dashboard
- [ ] Export applications to Excel/PDF
- [ ] Multi-language support
- [ ] Dark mode

---

## 🐛 Known Issues
1. Formal education save logic not fully implemented
2. Document upload size limit (2MB)
3. No email notification system yet
4. Some sections (C-G) need complete save logic implementation

---

## 📞 Support
For issues or questions, contact development team.

---

**Last Updated:** October 22, 2025
**Version:** 1.0.0
**Developer:** Praditya27-stack
