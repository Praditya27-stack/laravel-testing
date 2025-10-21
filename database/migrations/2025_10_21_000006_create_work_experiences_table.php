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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('company_name');
            $table->string('position');
            $table->decimal('salary', 15, 2)->nullable();
            $table->date('period_start');
            $table->date('period_end')->nullable();
            $table->text('reason_for_leaving')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_work_exp_user');
            $table->index(['user_id', 'period_start', 'period_end'], 'idx_user_work_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
