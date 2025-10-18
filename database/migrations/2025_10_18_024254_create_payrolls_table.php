<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('period'); // Format: YYYY-MM (e.g., 2024-01)
            $table->date('payment_date');
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('allowance_transport', 15, 2)->default(0);
            $table->decimal('allowance_meal', 15, 2)->default(0);
            $table->decimal('allowance_housing', 15, 2)->default(0);
            $table->decimal('allowance_other', 15, 2)->default(0);
            $table->decimal('overtime_pay', 15, 2)->default(0);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('gross_salary', 15, 2)->default(0); // Total sebelum potongan
            $table->decimal('deduction_tax', 15, 2)->default(0); // PPh 21
            $table->decimal('deduction_insurance', 15, 2)->default(0); // BPJS
            $table->decimal('deduction_loan', 15, 2)->default(0);
            $table->decimal('deduction_other', 15, 2)->default(0);
            $table->decimal('total_deduction', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2)->default(0); // Take home pay
            $table->enum('status', ['draft', 'processed', 'paid'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
