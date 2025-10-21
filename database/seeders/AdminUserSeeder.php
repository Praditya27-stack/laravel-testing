<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@aisin.co.id',
            'password' => Hash::make('Admin@2025'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@aisin.co.id');
        $this->command->info('Password: Admin@2025');
        $this->command->line('');

        // Create HR Recruiter User
        $hrRecruiter = User::create([
            'name' => 'HR Recruiter',
            'email' => 'hr@aisin.co.id',
            'password' => Hash::make('HR@2025'),
            'email_verified_at' => now(),
        ]);

        $hrRecruiter->assignRole('hr_recruiter');

        $this->command->info('HR Recruiter user created successfully!');
        $this->command->info('Email: hr@aisin.co.id');
        $this->command->info('Password: HR@2025');
        $this->command->line('');

        // Create Interviewer User
        $interviewer = User::create([
            'name' => 'Interviewer',
            'email' => 'interviewer@aisin.co.id',
            'password' => Hash::make('Interviewer@2025'),
            'email_verified_at' => now(),
        ]);

        $interviewer->assignRole('interviewer');

        $this->command->info('Interviewer user created successfully!');
        $this->command->info('Email: interviewer@aisin.co.id');
        $this->command->info('Password: Interviewer@2025');
        $this->command->line('');

        // Create Manager User
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@aisin.co.id',
            'password' => Hash::make('Manager@2025'),
            'email_verified_at' => now(),
        ]);

        $manager->assignRole('manager');

        $this->command->info('Manager user created successfully!');
        $this->command->info('Email: manager@aisin.co.id');
        $this->command->info('Password: Manager@2025');
        $this->command->line('');

        // Create Test Applicant User
        $applicant = User::create([
            'name' => 'Test Applicant',
            'email' => 'applicant@test.com',
            'password' => Hash::make('Applicant@2025'),
            'email_verified_at' => now(),
        ]);

        $applicant->assignRole('applicant');

        $this->command->info('Test Applicant user created successfully!');
        $this->command->info('Email: applicant@test.com');
        $this->command->info('Password: Applicant@2025');
        $this->command->line('');

        $this->command->info('===========================================');
        $this->command->info('Total 5 users created with different roles!');
        $this->command->info('===========================================');
    }
}
