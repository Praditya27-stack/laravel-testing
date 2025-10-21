<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Job Management
            'view-jobs',
            'create-jobs',
            'edit-jobs',
            'delete-jobs',
            'publish-jobs',
            
            // Application Management
            'view-applications',
            'create-applications',
            'edit-applications',
            'delete-applications',
            'apply-job',
            
            // Recruitment Process
            'review-administrative',
            'manage-psychotests',
            'send-psychotest-invitation',
            'view-psychotest-results',
            'conduct-interview',
            'schedule-interview',
            'assess-interview',
            'manage-background-checks',
            'send-background-check-form',
            'manage-medical-checkups',
            'import-mcu-results',
            'approve-hiring',
            'send-offer-letter',
            
            // Candidate Pool
            'view-candidate-pool',
            'create-candidate-pool',
            'edit-candidate-pool',
            'delete-candidate-pool',
            'convert-candidate',
            
            // Analytics & Reports
            'view-analytics',
            'export-reports',
            'export-realta-format',
            
            // Template Management
            'view-templates',
            'create-templates',
            'edit-templates',
            'delete-templates',
            
            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'assign-roles',
            
            // System Settings
            'view-settings',
            'edit-settings',
            'view-activity-log',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. Applicant Role
        $applicant = Role::create(['name' => 'applicant']);
        $applicant->givePermissionTo([
            'view-jobs',
            'apply-job',
            'view-applications', // Own applications only
        ]);

        // 2. HR Recruiter Role
        $hrRecruiter = Role::create(['name' => 'hr_recruiter']);
        $hrRecruiter->givePermissionTo([
            'view-jobs',
            'create-jobs',
            'edit-jobs',
            'publish-jobs',
            'view-applications',
            'edit-applications',
            'review-administrative',
            'manage-psychotests',
            'send-psychotest-invitation',
            'view-psychotest-results',
            'schedule-interview',
            'manage-background-checks',
            'send-background-check-form',
            'manage-medical-checkups',
            'import-mcu-results',
            'view-candidate-pool',
            'create-candidate-pool',
            'edit-candidate-pool',
            'convert-candidate',
            'view-analytics',
            'export-reports',
            'export-realta-format',
            'view-templates',
            'create-templates',
            'edit-templates',
        ]);

        // 3. Interviewer Role
        $interviewer = Role::create(['name' => 'interviewer']);
        $interviewer->givePermissionTo([
            'view-applications',
            'conduct-interview',
            'assess-interview',
        ]);

        // 4. Manager Role
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view-jobs',
            'view-applications',
            'conduct-interview',
            'assess-interview',
            'approve-hiring',
            'send-offer-letter',
            'view-analytics',
            'export-reports',
        ]);

        // 5. Admin Role (Super Admin)
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Created roles: applicant, hr_recruiter, interviewer, manager, admin');
        $this->command->info('Created ' . count($permissions) . ' permissions');
    }
}
