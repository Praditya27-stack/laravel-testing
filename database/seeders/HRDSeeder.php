<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HRDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Users
        $users = [
            [
                'name' => 'Admin HRD',
                'email' => 'admin@erp.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager IT',
                'email' => 'manager.it@erp.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        // Create Departments
        $departments = [
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Departemen IT bertanggung jawab atas infrastruktur teknologi',
                'manager_id' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Departemen HR mengelola sumber daya manusia',
                'manager_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Departemen keuangan dan akuntansi',
                'manager_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Departemen pemasaran dan penjualan',
                'manager_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->insert($dept);
        }

        // Create Positions
        $positions = [
            // IT Positions
            ['name' => 'IT Manager', 'code' => 'IT-MGR', 'description' => 'Manager IT', 'department_id' => 1, 'level' => 3, 'min_salary' => 15000000, 'max_salary' => 25000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senior Developer', 'code' => 'IT-SDEV', 'description' => 'Senior Developer', 'department_id' => 1, 'level' => 2, 'min_salary' => 10000000, 'max_salary' => 15000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Junior Developer', 'code' => 'IT-JDEV', 'description' => 'Junior Developer', 'department_id' => 1, 'level' => 1, 'min_salary' => 5000000, 'max_salary' => 8000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // HR Positions
            ['name' => 'HR Manager', 'code' => 'HR-MGR', 'description' => 'Manager HR', 'department_id' => 2, 'level' => 3, 'min_salary' => 12000000, 'max_salary' => 20000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR Staff', 'code' => 'HR-STF', 'description' => 'Staff HR', 'department_id' => 2, 'level' => 1, 'min_salary' => 5000000, 'max_salary' => 8000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Finance Positions
            ['name' => 'Finance Manager', 'code' => 'FIN-MGR', 'description' => 'Manager Finance', 'department_id' => 3, 'level' => 3, 'min_salary' => 15000000, 'max_salary' => 25000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accountant', 'code' => 'FIN-ACC', 'description' => 'Akuntan', 'department_id' => 3, 'level' => 2, 'min_salary' => 7000000, 'max_salary' => 12000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Marketing Positions
            ['name' => 'Marketing Manager', 'code' => 'MKT-MGR', 'description' => 'Manager Marketing', 'department_id' => 4, 'level' => 3, 'min_salary' => 12000000, 'max_salary' => 20000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing Staff', 'code' => 'MKT-STF', 'description' => 'Staff Marketing', 'department_id' => 4, 'level' => 1, 'min_salary' => 5000000, 'max_salary' => 8000000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($positions as $pos) {
            DB::table('positions')->insert($pos);
        }

        // Create Employees
        $employees = [
            [
                'employee_number' => 'EMP001',
                'user_id' => 1,
                'first_name' => 'Budi',
                'last_name' => 'Santoso',
                'email' => 'budi.santoso@erp.com',
                'phone' => '081234567890',
                'gender' => 'male',
                'birth_date' => '1990-05-15',
                'birth_place' => 'Jakarta',
                'address' => 'Jl. Sudirman No. 123',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12190',
                'id_card_number' => '3171051505900001',
                'tax_number' => '12.345.678.9-012.000',
                'department_id' => 2,
                'position_id' => 4,
                'join_date' => '2020-01-15',
                'permanent_date' => '2020-04-15',
                'employment_status' => 'permanent',
                'status' => 'active',
                'basic_salary' => 15000000,
                'bank_name' => 'BCA',
                'bank_account_number' => '1234567890',
                'bank_account_name' => 'Budi Santoso',
                'emergency_contact_name' => 'Siti Santoso',
                'emergency_contact_phone' => '081234567891',
                'emergency_contact_relation' => 'Istri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_number' => 'EMP002',
                'user_id' => 2,
                'first_name' => 'Andi',
                'last_name' => 'Wijaya',
                'email' => 'andi.wijaya@erp.com',
                'phone' => '081234567892',
                'gender' => 'male',
                'birth_date' => '1988-08-20',
                'birth_place' => 'Bandung',
                'address' => 'Jl. Asia Afrika No. 45',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'postal_code' => '40111',
                'id_card_number' => '3273082008880002',
                'tax_number' => '23.456.789.0-123.000',
                'department_id' => 1,
                'position_id' => 1,
                'join_date' => '2019-03-01',
                'permanent_date' => '2019-06-01',
                'employment_status' => 'permanent',
                'status' => 'active',
                'basic_salary' => 20000000,
                'bank_name' => 'Mandiri',
                'bank_account_number' => '9876543210',
                'bank_account_name' => 'Andi Wijaya',
                'emergency_contact_name' => 'Dewi Wijaya',
                'emergency_contact_phone' => '081234567893',
                'emergency_contact_relation' => 'Istri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_number' => 'EMP003',
                'user_id' => null,
                'first_name' => 'Siti',
                'last_name' => 'Nurhaliza',
                'email' => 'siti.nurhaliza@erp.com',
                'phone' => '081234567894',
                'gender' => 'female',
                'birth_date' => '1995-03-10',
                'birth_place' => 'Surabaya',
                'address' => 'Jl. Pemuda No. 67',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'postal_code' => '60271',
                'id_card_number' => '3578031003950003',
                'tax_number' => '34.567.890.1-234.000',
                'department_id' => 1,
                'position_id' => 2,
                'join_date' => '2021-06-01',
                'permanent_date' => '2021-09-01',
                'employment_status' => 'permanent',
                'status' => 'active',
                'basic_salary' => 12000000,
                'bank_name' => 'BNI',
                'bank_account_number' => '5555666677',
                'bank_account_name' => 'Siti Nurhaliza',
                'emergency_contact_name' => 'Ahmad Nurhaliza',
                'emergency_contact_phone' => '081234567895',
                'emergency_contact_relation' => 'Ayah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_number' => 'EMP004',
                'user_id' => null,
                'first_name' => 'Rudi',
                'last_name' => 'Hartono',
                'email' => 'rudi.hartono@erp.com',
                'phone' => '081234567896',
                'gender' => 'male',
                'birth_date' => '1998-11-25',
                'birth_place' => 'Yogyakarta',
                'address' => 'Jl. Malioboro No. 89',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'postal_code' => '55271',
                'id_card_number' => '3471112511980004',
                'tax_number' => '45.678.901.2-345.000',
                'department_id' => 1,
                'position_id' => 3,
                'join_date' => '2023-01-10',
                'permanent_date' => null,
                'employment_status' => 'probation',
                'status' => 'active',
                'basic_salary' => 6000000,
                'bank_name' => 'BRI',
                'bank_account_number' => '8888999900',
                'bank_account_name' => 'Rudi Hartono',
                'emergency_contact_name' => 'Sri Hartono',
                'emergency_contact_phone' => '081234567897',
                'emergency_contact_relation' => 'Ibu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($employees as $emp) {
            DB::table('employees')->insert($emp);
        }

        // Create Attendances (Last 7 days for all employees)
        $today = Carbon::today();
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            
            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            foreach ([1, 2, 3, 4] as $empId) {
                $checkIn = $date->copy()->setTime(8, rand(0, 30), 0);
                $checkOut = $date->copy()->setTime(17, rand(0, 30), 0);
                $lateMinutes = max(0, $checkIn->diffInMinutes($date->copy()->setTime(8, 0, 0)));
                
                DB::table('attendances')->insert([
                    'employee_id' => $empId,
                    'date' => $date->toDateString(),
                    'check_in' => $checkIn->toTimeString(),
                    'check_out' => $checkOut->toTimeString(),
                    'check_in_location' => 'Office',
                    'check_out_location' => 'Office',
                    'status' => $lateMinutes > 0 ? 'late' : 'present',
                    'late_minutes' => $lateMinutes,
                    'early_leave_minutes' => 0,
                    'overtime_minutes' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Create Leave Requests
        $leaves = [
            [
                'employee_id' => 1,
                'leave_type' => 'annual',
                'start_date' => Carbon::now()->addDays(10)->toDateString(),
                'end_date' => Carbon::now()->addDays(12)->toDateString(),
                'total_days' => 3,
                'reason' => 'Liburan keluarga',
                'status' => 'approved',
                'approved_by' => 1,
                'approved_at' => now(),
                'approval_notes' => 'Disetujui',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'leave_type' => 'sick',
                'start_date' => Carbon::now()->subDays(2)->toDateString(),
                'end_date' => Carbon::now()->subDays(2)->toDateString(),
                'total_days' => 1,
                'reason' => 'Sakit demam',
                'status' => 'approved',
                'approved_by' => 2,
                'approved_at' => now(),
                'approval_notes' => 'Cepat sembuh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'leave_type' => 'annual',
                'start_date' => Carbon::now()->addDays(20)->toDateString(),
                'end_date' => Carbon::now()->addDays(21)->toDateString(),
                'total_days' => 2,
                'reason' => 'Acara keluarga',
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'approval_notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($leaves as $leave) {
            DB::table('leaves')->insert($leave);
        }

        // Create Payrolls (Current month for all employees)
        $currentPeriod = Carbon::now()->format('Y-m');
        $payrolls = [
            [
                'employee_id' => 1,
                'period' => $currentPeriod,
                'payment_date' => Carbon::now()->endOfMonth()->toDateString(),
                'basic_salary' => 15000000,
                'allowance_transport' => 500000,
                'allowance_meal' => 750000,
                'allowance_housing' => 2000000,
                'allowance_other' => 0,
                'overtime_pay' => 0,
                'bonus' => 1000000,
                'gross_salary' => 19250000,
                'deduction_tax' => 1925000,
                'deduction_insurance' => 300000,
                'deduction_loan' => 0,
                'deduction_other' => 0,
                'total_deduction' => 2225000,
                'net_salary' => 17025000,
                'status' => 'processed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'period' => $currentPeriod,
                'payment_date' => Carbon::now()->endOfMonth()->toDateString(),
                'basic_salary' => 20000000,
                'allowance_transport' => 750000,
                'allowance_meal' => 1000000,
                'allowance_housing' => 3000000,
                'allowance_other' => 500000,
                'overtime_pay' => 0,
                'bonus' => 2000000,
                'gross_salary' => 27250000,
                'deduction_tax' => 2725000,
                'deduction_insurance' => 400000,
                'deduction_loan' => 0,
                'deduction_other' => 0,
                'total_deduction' => 3125000,
                'net_salary' => 24125000,
                'status' => 'processed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'period' => $currentPeriod,
                'payment_date' => Carbon::now()->endOfMonth()->toDateString(),
                'basic_salary' => 12000000,
                'allowance_transport' => 500000,
                'allowance_meal' => 750000,
                'allowance_housing' => 1500000,
                'allowance_other' => 0,
                'overtime_pay' => 500000,
                'bonus' => 500000,
                'gross_salary' => 15750000,
                'deduction_tax' => 1575000,
                'deduction_insurance' => 300000,
                'deduction_loan' => 0,
                'deduction_other' => 0,
                'total_deduction' => 1875000,
                'net_salary' => 13875000,
                'status' => 'processed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'period' => $currentPeriod,
                'payment_date' => Carbon::now()->endOfMonth()->toDateString(),
                'basic_salary' => 6000000,
                'allowance_transport' => 300000,
                'allowance_meal' => 500000,
                'allowance_housing' => 1000000,
                'allowance_other' => 0,
                'overtime_pay' => 0,
                'bonus' => 0,
                'gross_salary' => 7800000,
                'deduction_tax' => 390000,
                'deduction_insurance' => 200000,
                'deduction_loan' => 0,
                'deduction_other' => 0,
                'total_deduction' => 590000,
                'net_salary' => 7210000,
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($payrolls as $payroll) {
            DB::table('payrolls')->insert($payroll);
        }

        $this->command->info('HRD data seeded successfully!');
    }
}
