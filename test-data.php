<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Database Connection...\n\n";

try {
    $employees = \App\Models\Employee::count();
    $departments = \App\Models\Department::count();
    $attendances = \App\Models\Attendance::count();
    $leaves = \App\Models\Leave::count();
    $payrolls = \App\Models\Payroll::count();
    
    echo "✓ Employees: $employees\n";
    echo "✓ Departments: $departments\n";
    echo "✓ Attendances: $attendances\n";
    echo "✓ Leaves: $leaves\n";
    echo "✓ Payrolls: $payrolls\n\n";
    
    if ($employees > 0) {
        echo "Sample Employee:\n";
        $emp = \App\Models\Employee::with(['department', 'position'])->first();
        echo "- Name: {$emp->full_name}\n";
        echo "- Email: {$emp->email}\n";
        echo "- Department: {$emp->department->name}\n";
        echo "- Position: {$emp->position->name}\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
