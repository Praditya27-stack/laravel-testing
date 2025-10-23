<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // List semua role yang dibutuhkan
        $roles = [
            'admin',
            'hr_recruiter',
            'interviewer',
            'manager',
            'applicant',
        ];

        // Buat semua role
        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);

            $this->command->info("✓ Role '{$roleName}' created!");
        }
    }
}
