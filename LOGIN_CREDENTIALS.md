# Login Credentials - PT Aisin Recruitment System

**Created:** 2025-10-21  
**Total Users:** 5

---

## 🔐 Admin Accounts

### 1. Super Administrator
**Role:** Admin (Full Access)  
**Email:** `admin@aisin.co.id`  
**Password:** `Admin@2025`

**Permissions:** ALL (43 permissions)
- Full system access
- User management
- System settings
- All recruitment features

---

### 2. HR Recruiter
**Role:** HR Recruiter  
**Email:** `hr@aisin.co.id`  
**Password:** `HR@2025`

**Permissions:**
- Job management (create, edit, publish)
- Application management
- Administrative review
- Psychotest management
- Interview scheduling
- Background check management
- MCU management
- Candidate pool management
- Analytics & reports
- Template management

**Use Case:** Main recruitment team member

---

### 3. Interviewer
**Role:** Interviewer  
**Email:** `interviewer@aisin.co.id`  
**Password:** `Interviewer@2025`

**Permissions:**
- View applications
- Conduct interviews
- Assess candidates

**Use Case:** Department heads, technical interviewers

---

### 4. Manager
**Role:** Manager  
**Email:** `manager@aisin.co.id`  
**Password:** `Manager@2025`

**Permissions:**
- View jobs
- View applications
- Conduct interviews
- Assess candidates
- Approve hiring
- Send offer letters
- View analytics
- Export reports

**Use Case:** Department managers, hiring managers

---

### 5. Test Applicant
**Role:** Applicant  
**Email:** `applicant@test.com`  
**Password:** `Applicant@2025`

**Permissions:**
- View jobs
- Apply for jobs
- View own applications

**Use Case:** Testing applicant portal

---

## 🚀 Quick Start

### Start Development Server
```bash
php artisan serve
```

### Access Application
```
http://localhost:8000
```

### Login
1. Go to login page
2. Use any credentials above
3. Test different role permissions

---

## 🔑 Password Policy

**Current passwords are for DEVELOPMENT only!**

For PRODUCTION, please:
1. Change all default passwords
2. Implement strong password policy
3. Enable 2FA (Two-Factor Authentication)
4. Use environment-specific credentials

---

## 👥 Role Hierarchy

```
Admin (Super Admin)
  ├── Full system access
  └── Can manage all users and settings

Manager
  ├── Hiring approval
  ├── Interview & assessment
  └── Analytics access

HR Recruiter
  ├── Full recruitment process
  ├── Candidate management
  └── Template management

Interviewer
  ├── View applications
  └── Conduct interviews

Applicant
  ├── View jobs
  └── Submit applications
```

---

## 📊 Database Status

```
Total Users: 6 (5 created + 1 default)
Total Roles: 5
Total Permissions: 43
Role-Permission Assignments: 82
```

---

## 🔧 User Management Commands

### Create New User (via Tinker)
```bash
php artisan tinker
```

```php
$user = \App\Models\User::create([
    'name' => 'New User',
    'email' => 'user@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);

// Assign role
$user->assignRole('hr_recruiter');

// Or assign multiple roles
$user->assignRole(['hr_recruiter', 'interviewer']);

// Give specific permission
$user->givePermissionTo('manage-jobs');
```

### List All Users
```bash
php artisan tinker
```

```php
\App\Models\User::with('roles')->get();
```

### Check User Permissions
```php
$user = \App\Models\User::find(1);
$user->getAllPermissions();
$user->hasRole('admin');
$user->can('manage-jobs');
```

---

## 🛡️ Security Notes

### Development Environment
- ✅ Default credentials provided
- ✅ Email verification enabled
- ✅ Password hashing (bcrypt)
- ✅ RBAC implemented

### Production Checklist
- [ ] Change all default passwords
- [ ] Remove test accounts
- [ ] Enable 2FA
- [ ] Implement password reset
- [ ] Set up email verification
- [ ] Configure session security
- [ ] Enable HTTPS
- [ ] Set up rate limiting
- [ ] Configure CORS
- [ ] Enable audit logging

---

## 📝 Testing Scenarios

### Test as Admin
```
Login: admin@aisin.co.id
Password: Admin@2025

Test:
- Create new job vacancy
- Manage users
- View all applications
- Configure system settings
```

### Test as HR Recruiter
```
Login: hr@aisin.co.id
Password: HR@2025

Test:
- Post job vacancy
- Review applications
- Send psychotest invitations
- Schedule interviews
- Manage candidate pool
```

### Test as Interviewer
```
Login: interviewer@aisin.co.id
Password: Interviewer@2025

Test:
- View assigned interviews
- Assess candidates
- Submit interview feedback
```

### Test as Manager
```
Login: manager@aisin.co.id
Password: Manager@2025

Test:
- Conduct interviews
- Approve hiring
- View analytics
- Export reports
```

### Test as Applicant
```
Login: applicant@test.com
Password: Applicant@2025

Test:
- Browse jobs
- Submit application
- Upload CV
- Track application status
```

---

## 🔄 Reset Users (if needed)

```bash
# Reset database and recreate users
php artisan migrate:fresh --seed
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=NotificationTemplateSeeder
php artisan db:seed --class=AdminUserSeeder
```

---

## 📞 Support

For password reset or account issues:
- Contact: admin@aisin.co.id
- Or reset via: `php artisan tinker`

---

**⚠️ IMPORTANT SECURITY WARNING**

**These credentials are for DEVELOPMENT ONLY!**

Before deploying to production:
1. Change ALL passwords
2. Remove test accounts
3. Implement proper authentication
4. Enable security features
5. Follow security best practices

---

**Last Updated:** 2025-10-21  
**Environment:** Development  
**Status:** ✅ Ready for Testing
