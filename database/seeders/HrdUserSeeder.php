<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class HrdUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create HR Recruiter role if not exists
        $hrRole = Role::firstOrCreate(['name' => 'hr_recruiter']);
        
        // Create HRD user
        $hrdUser = User::firstOrCreate(
            ['email' => 'hrd@aisin.co.id'],
            [
                'name' => 'HR Recruiter',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        
        // Assign role
        if (!$hrdUser->hasRole('hr_recruiter')) {
            $hrdUser->assignRole('hr_recruiter');
        }
        
        $this->command->info('HRD user created successfully!');
        $this->command->info('Email: hrd@aisin.co.id');
        $this->command->info('Password: password123');
    }
}
