# 📋 TODO LIST - ERP RECRUITMENT SYSTEM

## 🔴 CRITICAL - MUST HAVE (Phase 1)

### **1. PROFILE COMPLETION SYSTEM** 🔴 ✅ COMPLETE
**NEW FLOW:** User must complete profile 100% before applying for jobs!

**Tasks:**
- [x] Create database tables (7 tables)
- [x] Create models (ApplicantProfile, Education, Experience, Skills, Documents, References)
- [x] Create ProfileCompletion component with full CRUD
- [x] Build profile completion view with tabs
- [x] Add progress tracking (percentage calculation)
- [x] Create MyApplications component
- [x] Create ApplicationTracker component (visual timeline)
- [x] Add routes untuk applicant
- [x] Update User model with relationships

**Profile Sections:**
- Personal Info (30%)
- Education (20%)
- Experience (20%)
- Skills (10%)
- Documents (15%)
- References (5%)

---

### **1B. JOB BROWSING & APPLICATION SYSTEM** 
**Problem:** Need public job listing and application system with profile check!

**Tasks:**
- [ ] Create public job listing page (with filters)
- [ ] Build job detail page
- [ ] Add "Apply" button with profile completion check
- [ ] Create application submission flow
- [ ] Show profile completion warning if < 100%
- [ ] Update applicant layout sidebar
- [ ] Add job search & filter functionality

**Files to Create:**
```
app/Livewire/Jobs/JobListing.php
app/Livewire/Jobs/JobDetail.php
app/Livewire/Jobs/ApplyJob.php
resources/views/livewire/jobs/job-listing.blade.php
resources/views/livewire/jobs/job-detail.blade.php
resources/views/livewire/jobs/apply-job.blade.php
```

**Routes:**
```php
Route::get('/jobs', JobListing::class)->name('jobs.index');
Route::get('/jobs/{id}', JobDetail::class)->name('jobs.show');
Route::post('/jobs/{id}/apply', [ApplyJob::class, 'apply'])->name('jobs.apply');
```

---

### **2. OFFER LETTER ACCEPTANCE** 🔴 ✅ COMPLETE
**Problem:** Kandidat terima offer letter tapi tidak bisa accept/decline!

**Tasks:**
- [x] Create `AcceptOfferLetter.php` component
- [x] Build acceptance form (accept/decline + reason)
- [x] Add digital signature field
- [x] Terms & conditions checkbox
- [x] Update offer status on submit
- [ ] Send confirmation email to HR (TODO: Email integration)

**Files to Create:**
```
app/Livewire/Applicant/AcceptOfferLetter.php
resources/views/livewire/applicant/accept-offer-letter.blade.php
```

**Route:**
```php
Route::get('/offer/{token}', AcceptOfferLetter::class)->name('offer.accept');
```

---

### **3. EMAIL INTEGRATION** 🔴
**Problem:** Semua email masih TODO!

**Tasks:**
- [ ] Configure Laravel Mail di `.env`
- [ ] Create Mailable classes
- [ ] Create email templates
- [ ] Implement queue jobs
- [ ] Test email delivery

**Install:**
```bash
# No need to install, Laravel Mail is built-in
# Just configure .env
```

**Configure `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@aisin.co.id
MAIL_FROM_NAME="PT Aisin Indonesia"
```

**Files to Create:**
```
app/Mail/PsychotestInvitation.php
app/Mail/InterviewInvitation.php
app/Mail/BackgroundCheckRequest.php
app/Mail/MCUScheduleNotification.php
app/Mail/OfferLetterMail.php
app/Mail/OnboardingInfo.php
app/Jobs/SendBulkEmails.php
resources/views/emails/psychotest-invitation.blade.php
resources/views/emails/interview-invitation.blade.php
resources/views/emails/bgc-request.blade.php
resources/views/emails/mcu-schedule.blade.php
resources/views/emails/offer-letter.blade.php
resources/views/emails/onboarding.blade.php
```

**Example Implementation:**
```php
// app/Mail/PsychotestInvitation.php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class PsychotestInvitation extends Mailable
{
    public $invitation;
    
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }
    
    public function build()
    {
        return $this->subject('Undangan Psychotest - PT Aisin Indonesia')
                    ->view('emails.psychotest-invitation');
    }
}

// Usage in component:
Mail::to($candidate->email)->send(new PsychotestInvitation($invitation));
```

---

### **4. WHATSAPP INTEGRATION** 🔴
**Problem:** WhatsApp notifications masih TODO!

**Tasks:**
- [ ] Choose provider (Fonnte/Twilio)
- [ ] Get API credentials
- [ ] Create WhatsApp service class
- [ ] Implement message templates
- [ ] Test message delivery

**Recommended: Fonnte (Indonesian provider)**
```bash
composer require guzzlehttp/guzzle
```

**Create Service:**
```
app/Services/WhatsAppService.php
```

**Example Implementation:**
```php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.fonnte.com';
    
    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key');
    }
    
    public function sendMessage($phone, $message)
    {
        return Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->post($this->baseUrl . '/send', [
            'target' => $phone,
            'message' => $message,
        ]);
    }
}
```

**Configure `.env`:**
```env
FONNTE_API_KEY=your-api-key-here
```

---

### **5. DOCUMENT UPLOAD SYSTEM** 🔴
**Problem:** Kandidat tidak bisa upload dokumen!

**Tasks:**
- [ ] Create `DocumentUpload.php` component
- [ ] Build file upload UI
- [ ] Add validation (file type, size)
- [ ] Store files securely
- [ ] Show upload status
- [ ] Allow document replacement

**Files to Create:**
```
app/Livewire/Applicant/DocumentUpload.php
resources/views/livewire/applicant/document-upload.blade.php
```

**Migration:**
```php
Schema::create('application_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('application_id')->constrained()->onDelete('cascade');
    $table->string('document_type'); // cv, ktp, ijazah, etc
    $table->string('file_path');
    $table->string('original_filename');
    $table->integer('file_size');
    $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
    $table->text('rejection_reason')->nullable();
    $table->timestamps();
});
```

---

## 🟡 IMPORTANT - SHOULD HAVE (Phase 2)

### **6. PDF GENERATION**
**Tasks:**
- [ ] Install DomPDF
- [ ] Create PDF templates
- [ ] Generate approval documents
- [ ] Generate offer letters
- [ ] Generate MCU reports

**Install:**
```bash
composer require barryvdh/laravel-dompdf
```

**Usage:**
```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('pdf.offer-letter', ['data' => $data]);
return $pdf->download('offer-letter.pdf');
```

---

### **7. EXCEL EXPORT/IMPORT**
**Tasks:**
- [ ] Install Laravel Excel
- [ ] Create export classes
- [ ] Create import classes
- [ ] Build download templates
- [ ] Implement bulk MCU import

**Install:**
```bash
composer require maatwebsite/excel
```

**Files to Create:**
```
app/Exports/HiredCandidatesExport.php
app/Exports/RealtaFormatExport.php
app/Imports/MCUResultsImport.php
```

---

### **8. NOTIFICATION SYSTEM**
**Tasks:**
- [ ] Create notifications table
- [ ] Build notification component
- [ ] Add notification bell icon
- [ ] Mark as read functionality
- [ ] Email + in-app notifications

**Migration:**
```bash
php artisan notifications:table
php artisan migrate
```

---

### **9. PSYCHOTEST PLATFORM**
**Problem:** Invitation sent, tapi tidak ada platform untuk test!

**Options:**
1. **Integrate with external provider** (Recommended)
   - Integrate with existing psychotest platform
   - Get API credentials
   - Sync results back to system

2. **Build internal platform** (Complex)
   - Create test questions database
   - Build test taking interface
   - Implement timer
   - Auto-scoring system

**Recommended:** Use external provider like:
- Tes Psikologi Online
- Psikotes.id
- Or custom integration with company's existing tool

---

### **10. INTERVIEW CONFIRMATION**
**Tasks:**
- [ ] Create interview confirmation page
- [ ] Allow reschedule request
- [ ] Add to calendar button
- [ ] Send reminders (H-1, H-0)

---

## 🟢 NICE TO HAVE (Phase 3)

### **11. Advanced Analytics**
- [ ] Time-to-hire metrics
- [ ] Source effectiveness
- [ ] Stage conversion rates
- [ ] Candidate pipeline
- [ ] Export analytics to PDF

### **12. Calendar Integration**
- [ ] Google Calendar sync
- [ ] Outlook Calendar sync
- [ ] iCal export

### **13. In-app Messaging**
- [ ] Chat between HR and candidate
- [ ] Message history
- [ ] File attachments

### **14. Mobile Responsive**
- [ ] Test on mobile devices
- [ ] Fix UI issues
- [ ] Optimize for touch

### **15. Security Enhancements**
- [ ] Two-factor authentication
- [ ] IP whitelisting for admin
- [ ] Audit logs
- [ ] Data encryption

---

## 🔧 TECHNICAL DEBT

### **Code Quality**
- [ ] Add PHPUnit tests
- [ ] Add Feature tests
- [ ] Code documentation
- [ ] API documentation

### **Performance**
- [ ] Database indexing review
- [ ] Query optimization
- [ ] Implement caching (Redis)
- [ ] Lazy loading optimization

### **Deployment**
- [ ] Create deployment script
- [ ] Set up CI/CD pipeline
- [ ] Configure production environment
- [ ] Set up monitoring (Sentry)

---

## 📝 NOTES

### **Current TODO Markers in Code:**
Search for `// TODO:` in codebase to find all pending implementations:

1. **Email sending** - Multiple locations
2. **WhatsApp sending** - Multiple locations
3. **PDF generation** - Approval docs, offer letters
4. **Excel export** - Hired candidates, Realta format
5. **File storage** - Document uploads

### **Database Seeding Needed:**
- [ ] Create seeders for testing
- [ ] Sample jobs
- [ ] Sample applications
- [ ] Sample users (HRD, Applicant)
- [ ] MCU clinics

### **Environment Variables to Add:**
```env
# Email
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=

# WhatsApp
FONNTE_API_KEY=

# File Storage
FILESYSTEM_DISK=public
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=

# Queue
QUEUE_CONNECTION=database
```

---

## 🎯 PRIORITY MATRIX

**DO FIRST (Critical & Urgent):**
1. Applicant Dashboard
2. Offer Acceptance Page
3. Email Integration

**SCHEDULE (Important but not urgent):**
4. WhatsApp Integration
5. Document Upload
6. PDF Generation

**DELEGATE (Urgent but not important):**
7. Excel Export
8. Notification System

**ELIMINATE (Neither urgent nor important):**
9. Advanced Analytics
10. Mobile App

---

## ✅ COMPLETION CHECKLIST

### **Phase 1 Complete When:**
- [ ] Applicant can see their application status
- [ ] Applicant can accept/decline offer
- [ ] All emails are actually sent
- [ ] Documents can be uploaded
- [ ] System is testable end-to-end

### **Phase 2 Complete When:**
- [ ] WhatsApp notifications work
- [ ] PDFs can be generated
- [ ] Excel export works
- [ ] Notifications are in-app
- [ ] System is production-ready

### **Phase 3 Complete When:**
- [ ] Analytics dashboard complete
- [ ] Calendar integration works
- [ ] Mobile responsive
- [ ] All polish items done
- [ ] System is launched

---

**Last Updated:** October 22, 2025  
**Status:** Phase 1 Ready to Start  
**Next Action:** Build Applicant Dashboard
