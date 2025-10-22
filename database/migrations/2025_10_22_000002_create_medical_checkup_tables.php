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
        // Medical Checkup Clinics Table
        Schema::create('mcu_clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('city')->nullable();
            $table->string('phone');
            $table->string('phone_alt')->nullable();
            $table->string('email')->nullable();
            $table->text('map_link')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active', 'idx_clinic_active');
        });

        // Medical Checkup Schedules Table
        Schema::create('medical_checkup_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained('mcu_clinics')->onDelete('cascade');
            $table->date('mcu_date');
            $table->time('mcu_time');
            $table->text('requirements')->nullable()->comment('JSON array of requirements');
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->foreignId('scheduled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['application_id', 'status'], 'idx_mcu_schedule_app_status');
            $table->index('mcu_date', 'idx_mcu_schedule_date');
            $table->index('clinic_id', 'idx_mcu_schedule_clinic');
        });

        // Medical Checkup Results Table
        Schema::create('medical_checkup_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('medical_checkup_schedules')->nullOnDelete();
            
            // File Upload
            $table->string('result_file_path')->nullable()->comment('Path to uploaded PDF');
            
            // Vital Signs
            $table->string('blood_pressure')->nullable()->comment('e.g., 120/80');
            $table->integer('heart_rate')->nullable()->comment('BPM');
            $table->decimal('body_temperature', 4, 1)->nullable()->comment('Celsius');
            $table->decimal('height', 5, 2)->nullable()->comment('cm');
            $table->decimal('weight', 5, 2)->nullable()->comment('kg');
            $table->decimal('bmi', 4, 2)->nullable()->comment('Body Mass Index');
            
            // Vision & Hearing
            $table->string('vision_left')->nullable()->comment('e.g., 6/6, 20/20');
            $table->string('vision_right')->nullable();
            $table->enum('hearing_test', ['pass', 'fail', 'pending'])->nullable();
            
            // Lab Tests
            $table->text('blood_test_results')->nullable()->comment('JSON or text');
            $table->text('urine_test_results')->nullable()->comment('JSON or text');
            $table->string('xray_result')->nullable()->comment('Normal/Abnormal');
            $table->text('xray_notes')->nullable();
            
            // Overall Assessment
            $table->enum('overall_fitness', ['fit', 'unfit', 'pending', 'need_retest'])->default('pending');
            $table->text('medical_notes')->nullable();
            $table->text('unfit_reason')->nullable();
            
            // Result Decision
            $table->enum('result', ['fit', 'unfit', 'pending', 'need_retest'])->default('pending');
            $table->date('result_date')->nullable();
            
            // Import Info
            $table->enum('import_method', ['manual', 'excel'])->default('manual');
            $table->string('imported_by_file')->nullable()->comment('Excel filename if bulk imported');
            
            // Assessor
            $table->foreignId('assessed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assessed_at')->nullable();
            
            $table->timestamps();

            $table->index(['application_id', 'result'], 'idx_mcu_result_app_result');
            $table->index('result', 'idx_mcu_result_result');
            $table->index('overall_fitness', 'idx_mcu_result_fitness');
            $table->index('import_method', 'idx_mcu_result_import');
        });

        // Medical Checkup Retest Table
        Schema::create('medical_checkup_retests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_result_id')->constrained('medical_checkup_results')->onDelete('cascade');
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->text('retest_reason');
            $table->date('retest_scheduled_date')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('application_id', 'idx_mcu_retest_app');
            $table->index('status', 'idx_mcu_retest_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_checkup_retests');
        Schema::dropIfExists('medical_checkup_results');
        Schema::dropIfExists('medical_checkup_schedules');
        Schema::dropIfExists('mcu_clinics');
    }
};
