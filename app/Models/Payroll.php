<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'period',
        'payment_date',
        'basic_salary',
        'allowance_transport',
        'allowance_meal',
        'allowance_housing',
        'allowance_other',
        'overtime_pay',
        'bonus',
        'gross_salary',
        'deduction_tax',
        'deduction_insurance',
        'deduction_loan',
        'deduction_other',
        'total_deduction',
        'net_salary',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'allowance_transport' => 'decimal:2',
        'allowance_meal' => 'decimal:2',
        'allowance_housing' => 'decimal:2',
        'allowance_other' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'bonus' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'deduction_tax' => 'decimal:2',
        'deduction_insurance' => 'decimal:2',
        'deduction_loan' => 'decimal:2',
        'deduction_other' => 'decimal:2',
        'total_deduction' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
