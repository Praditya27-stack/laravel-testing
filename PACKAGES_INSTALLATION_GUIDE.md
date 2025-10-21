# Package Installation Guide - PT Aisin Recruitment System

**Date:** 2025-10-21  
**Purpose:** Install all required packages without CDN dependencies

---

## 📦 Packages to Install

### Core Packages (Required)

1. **Livewire** - Real-time interactivity
2. **Spatie Permission** - RBAC system
3. **Spatie Media Library** - File attachments
4. **Spatie Activity Log** - Audit trail
5. **Laravel Excel** - Import/Export functionality
6. **DomPDF** - PDF generation
7. **Laravel Scout** - Search functionality
8. **Meilisearch** - Search engine
9. **Laravel Horizon** - Queue monitoring
10. **Predis** - Redis client

### Optional Packages

11. **Filament** - Admin panel (optional but recommended)

---

## 🚀 Installation Steps

### Step 1: Install All Packages

Run the batch script:
```bash
.\install-packages.bat
```

Or install manually one by one:
```bash
composer require livewire/livewire
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary
composer require spatie/laravel-activitylog
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
composer require laravel/scout
composer require meilisearch/meilisearch-php http-interop/http-factory-guzzle
composer require laravel/horizon
composer require predis/predis

# Optional
composer require filament/filament:"^3.0"
```

### Step 2: Publish Configurations

Run the publish script:
```bash
.\publish-configs.bat
```

Or publish manually:
```bash
php artisan livewire:publish --config
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
php artisan horizon:install
php artisan filament:install --panels
```

### Step 3: Run Migrations

Some packages add their own tables:
```bash
php artisan migrate
```

### Step 4: Configure Environment

Update `.env` file with package configurations.

---

## ⚙️ Package Configurations

### 1. Livewire

**Purpose:** Real-time UI components without SPA

**Use Cases:**
- Applicant dashboard
- Dynamic filters
- Interview scheduling UI
- File upload progress
- Modal dialogs

**Configuration:** `config/livewire.php`

**No CDN Required:** Livewire assets are published locally

---

### 2. Spatie Permission

**Purpose:** Role-Based Access Control (RBAC)

**Use Cases:**
- User roles (applicant, hr_recruiter, interviewer, admin)
- Permissions (view-jobs, manage-applications, conduct-interview)
- Role assignment

**Configuration:** `config/permission.php`

**Tables Created:**
- `roles`
- `permissions`
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`

**Note:** These tables already exist in your database (v1.0)

---

### 3. Spatie Media Library

**Purpose:** File attachment management

**Use Cases:**
- CV/Resume uploads
- Photo uploads
- Certificate attachments
- Document management
- MCU result files

**Configuration:** `config/media-library.php`

**Tables Created:**
- `media` (will be created if not using custom `attachments` table)

**Note:** You can configure to use your existing `attachments` table

---

### 4. Spatie Activity Log

**Purpose:** Audit trail and activity logging

**Use Cases:**
- Track who changed application status
- Log interview scheduling
- Record approval actions
- Monitor data changes

**Configuration:** `config/activitylog.php`

**Tables Created:**
- `activity_log` (already exists in your database)

---

### 5. Laravel Excel (Maatwebsite)

**Purpose:** Import/Export Excel files

**Use Cases:**
- Bulk MCU results import
- Export applicant data
- Export to Realta format
- Generate reports

**Configuration:** `config/excel.php`

**Features:**
- Import from Excel/CSV
- Export to Excel/CSV
- Queue support for large files
- Custom formatting

---

### 6. DomPDF (Barryvdh)

**Purpose:** Generate PDF documents

**Use Cases:**
- Offer letters
- Interview invitations
- Application forms
- Reports
- Approval documents

**Configuration:** `config/dompdf.php`

**Features:**
- HTML to PDF conversion
- Custom fonts
- Headers/footers
- Page numbering

---

### 7. Laravel Scout + Meilisearch

**Purpose:** Full-text search functionality

**Use Cases:**
- Search applicants by name, NIK, email
- Search jobs by title, department
- Filter candidates by skills
- Quick search across all data

**Configuration:** `config/scout.php`

**Setup Meilisearch:**
```bash
# Download Meilisearch (Windows)
# https://github.com/meilisearch/meilisearch/releases

# Or use Docker
docker run -d -p 7700:7700 getmeili/meilisearch:latest
```

**Environment Variables:**
```env
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=your-master-key
```

---

### 8. Laravel Horizon

**Purpose:** Queue monitoring and management

**Use Cases:**
- Monitor email sending jobs
- Track background check form sending
- Monitor MCU import jobs
- View failed jobs
- Retry failed jobs

**Configuration:** `config/horizon.php`

**Access Dashboard:**
```
http://localhost/horizon
```

**Start Horizon:**
```bash
php artisan horizon
```

**Supervisor Configuration Required** for production

---

### 9. Predis (Redis Client)

**Purpose:** Redis connection for caching and queues

**Configuration:** `.env`

```env
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

**Install Redis:**
- Windows: Use Redis for Windows or WSL
- Or use Laragon's Redis

---

### 10. Filament (Optional)

**Purpose:** Admin panel builder

**Use Cases:**
- Quick admin CRUD pages
- Job vacancy management
- Application review interface
- User management
- Settings management

**Configuration:** `config/filament.php`

**Access Panel:**
```
http://localhost/admin
```

**Create Admin User:**
```bash
php artisan make:filament-user
```

**Features:**
- Auto-generated CRUD
- Tables with filters
- Forms with validation
- Dashboard widgets
- Dark mode support

---

## 📧 Email Configuration

### Laravel Notifications

**Providers to Choose:**
- **SendGrid** (Recommended)
- **Mailgun**
- **AWS SES**
- **SMTP** (Gmail, Outlook)

### SendGrid Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@aisin.co.id
MAIL_FROM_NAME="PT Aisin Indonesia"
```

### Notification Channels

```php
// In your Notification class
public function via($notifiable)
{
    return ['mail', 'database'];
}
```

### Email Use Cases

1. **Psychotest Invitation** - Send test link with expiry
2. **Interview Invitation** - Send with ICS calendar attachment
3. **Status Updates** - Application stage changes
4. **Offer Letter** - PDF attachment
5. **Background Check Form** - Send to referees
6. **MCU Invitation** - Medical checkup details

---

## 🔧 Post-Installation Configuration

### 1. Update .env File

```env
# App
APP_NAME="PT Aisin Recruitment"
APP_URL=http://localhost

# Database (already configured)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=erp_system
DB_USERNAME=postgres
DB_PASSWORD=your-password

# Cache & Queue
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@aisin.co.id
MAIL_FROM_NAME="PT Aisin Indonesia"

# Scout
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=

# Filesystem
FILESYSTEM_DISK=public

# Horizon
HORIZON_DOMAIN=localhost
```

### 2. Create Storage Link

```bash
php artisan storage:link
```

### 3. Clear and Cache Config

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Set Permissions (if needed)

```bash
# Storage and cache directories should be writable
chmod -R 775 storage bootstrap/cache
```

---

## 📝 Create Initial Seeders

### Role & Permission Seeder

```bash
php artisan make:seeder RolePermissionSeeder
```

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view-jobs',
            'apply-job',
            'manage-jobs',
            'view-applications',
            'manage-applications',
            'review-administrative',
            'manage-psychotests',
            'conduct-interview',
            'manage-background-checks',
            'manage-medical-checkups',
            'approve-hiring',
            'manage-users',
            'view-analytics',
            'manage-templates',
            'manage-candidate-pool',
            'export-data',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $applicant = Role::create(['name' => 'applicant']);
        $applicant->givePermissionTo(['view-jobs', 'apply-job']);

        $hrRecruiter = Role::create(['name' => 'hr_recruiter']);
        $hrRecruiter->givePermissionTo([
            'view-jobs',
            'manage-jobs',
            'view-applications',
            'manage-applications',
            'review-administrative',
            'manage-psychotests',
            'manage-background-checks',
            'manage-medical-checkups',
            'view-analytics',
            'manage-templates',
            'manage-candidate-pool',
            'export-data',
        ]);

        $interviewer = Role::create(['name' => 'interviewer']);
        $interviewer->givePermissionTo([
            'view-applications',
            'conduct-interview',
        ]);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view-applications',
            'conduct-interview',
            'approve-hiring',
        ]);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
```

### Notification Template Seeder

```bash
php artisan make:seeder NotificationTemplateSeeder
```

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Psychotest Invitation',
                'type' => 'both',
                'stage' => 'psychotest_invite',
                'email_subject' => 'Undangan Psikotes - {{job_title}}',
                'email_body' => '<p>Yth. {{name}},</p><p>Selamat! Anda telah lolos tahap administratif untuk posisi {{job_title}}.</p><p>Silakan mengikuti psikotes pada:</p><ul><li>Tanggal: {{date}}</li><li>Waktu: {{time}}</li><li>Lokasi: {{location}}</li></ul><p>Link: {{link}}</p><p>Hormat kami,<br>PT Aisin Indonesia</p>',
                'whatsapp_message' => 'Halo {{name}}, Anda telah lolos tahap administratif untuk posisi {{job_title}}. Silakan ikuti psikotes pada {{date}} pukul {{time}}. Link: {{link}}',
                'available_variables' => json_encode(['name', 'job_title', 'date', 'time', 'location', 'link']),
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'name' => 'Interview Invitation',
                'type' => 'both',
                'stage' => 'interview_invite',
                'email_subject' => 'Undangan Interview - {{job_title}}',
                'email_body' => '<p>Yth. {{name}},</p><p>Selamat! Anda telah lolos tahap psikotes.</p><p>Kami mengundang Anda untuk interview:</p><ul><li>Tanggal: {{date}}</li><li>Waktu: {{time}}</li><li>Mode: {{mode}}</li><li>Lokasi/Link: {{location}}</li></ul><p>Mohon konfirmasi kehadiran Anda.</p><p>Hormat kami,<br>PT Aisin Indonesia</p>',
                'whatsapp_message' => 'Halo {{name}}, Anda diundang interview untuk posisi {{job_title}} pada {{date}} pukul {{time}}. Mode: {{mode}}. Mohon konfirmasi kehadiran.',
                'available_variables' => json_encode(['name', 'job_title', 'date', 'time', 'mode', 'location']),
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'name' => 'MCU Invitation',
                'type' => 'both',
                'stage' => 'mcu_invite',
                'email_subject' => 'Undangan Medical Checkup - {{job_title}}',
                'email_body' => '<p>Yth. {{name}},</p><p>Selamat! Anda telah lolos tahap interview.</p><p>Silakan melakukan Medical Checkup:</p><ul><li>Tanggal: {{date}}</li><li>Lokasi: {{location}}</li><li>Syarat: {{requirements}}</li></ul><p>Hormat kami,<br>PT Aisin Indonesia</p>',
                'whatsapp_message' => 'Halo {{name}}, Silakan MCU pada {{date}} di {{location}}. Syarat: {{requirements}}',
                'available_variables' => json_encode(['name', 'job_title', 'date', 'location', 'requirements']),
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'name' => 'Offer Letter',
                'type' => 'email',
                'stage' => 'offer',
                'email_subject' => 'Offering Letter - {{job_title}}',
                'email_body' => '<p>Yth. {{name}},</p><p>Selamat! Kami dengan senang hati menawarkan posisi {{job_title}} kepada Anda.</p><p>Detail:</p><ul><li>Posisi: {{position}}</li><li>Gaji: {{salary}}</li><li>Tanggal Bergabung: {{join_date}}</li><li>Tanggal Briefing: {{briefing_date}}</li></ul><p>Terlampir surat penawaran resmi.</p><p>Hormat kami,<br>PT Aisin Indonesia</p>',
                'whatsapp_message' => null,
                'available_variables' => json_encode(['name', 'job_title', 'position', 'salary', 'join_date', 'briefing_date']),
                'is_active' => true,
                'is_default' => true,
            ],
        ];

        foreach ($templates as $template) {
            NotificationTemplate::create($template);
        }
    }
}
```

### Run Seeders

```bash
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=NotificationTemplateSeeder
```

---

## ✅ Verification Checklist

After installation, verify:

- [ ] All packages installed via Composer
- [ ] All configs published
- [ ] Migrations run successfully
- [ ] Storage link created
- [ ] .env configured
- [ ] Redis running (if using)
- [ ] Meilisearch running (if using)
- [ ] Horizon dashboard accessible
- [ ] Filament admin accessible (if installed)
- [ ] Email sending works (test)
- [ ] File upload works
- [ ] Seeders run successfully

---

## 🚀 Next Steps

1. **Create Livewire Components**
   ```bash
   php artisan make:livewire ApplicantDashboard
   php artisan make:livewire JobList
   php artisan make:livewire ApplicationForm
   ```

2. **Create Models for v2.0 Tables**
   ```bash
   php artisan make:model InterviewAssessment
   php artisan make:model CandidatePool
   php artisan make:model RecruitmentAnalytic
   php artisan make:model NotificationTemplate
   ```

3. **Create Filament Resources** (if using Filament)
   ```bash
   php artisan make:filament-resource Job
   php artisan make:filament-resource Application
   php artisan make:filament-resource User
   ```

4. **Start Development**
   - Build applicant dashboard
   - Create job listing page
   - Implement application form
   - Build admin interface

---

## 📚 Documentation Links

- **Livewire:** https://livewire.laravel.com/docs
- **Spatie Permission:** https://spatie.be/docs/laravel-permission
- **Spatie Media Library:** https://spatie.be/docs/laravel-medialibrary
- **Spatie Activity Log:** https://spatie.be/docs/laravel-activitylog
- **Laravel Excel:** https://docs.laravel-excel.com
- **DomPDF:** https://github.com/barryvdh/laravel-dompdf
- **Laravel Scout:** https://laravel.com/docs/scout
- **Meilisearch:** https://www.meilisearch.com/docs
- **Laravel Horizon:** https://laravel.com/docs/horizon
- **Filament:** https://filamentphp.com/docs

---

**Installation Guide Version:** 1.0  
**Last Updated:** 2025-10-21  
**Status:** Ready for Installation
