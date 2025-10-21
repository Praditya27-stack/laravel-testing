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
        // Administrative Selection
        Schema::create('administrative_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained('applications')->onDelete('cascade');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 20)->default('pending')->comment('pending, passed, failed');
            $table->boolean('cv_complete')->default(false);
            $table->boolean('documents_valid')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique('application_id', 'idx_admin_sel_app');
            $table->index('status', 'idx_admin_sel_status');
        });

        // Psychotests
        Schema::create('psychotests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->string('test_type', 100)->comment('IQ, Personality, SMK, etc.');
            $table->string('invitation_token')->unique()->nullable();
            $table->timestamp('invitation_sent_at')->nullable();
            $table->foreignId('invitation_sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('test_scheduled_at')->nullable();
            $table->timestamp('test_completed_at')->nullable();
            $table->string('test_location')->nullable();
            $table->json('result_score')->nullable()->comment('Structured test scores');
            $table->string('result_file_path')->nullable();
            $table->string('status', 20)->default('invited')->comment('invited, scheduled, completed, failed, cancelled');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('application_id', 'idx_psycho_app');
            $table->unique('invitation_token', 'idx_psycho_token');
            $table->index('status', 'idx_psycho_status');
        });

        // Interviews
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->string('interview_type', 20)->comment('hr, user, technical');
            $table->foreignId('interviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('scheduled_at')->nullable();
            $table->foreignId('scheduled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('mode', 20)->comment('onsite, zoom, phone');
            $table->string('location_or_link')->nullable();
            $table->integer('duration_minutes')->default(60);
            $table->string('status', 20)->default('scheduled')->comment('scheduled, completed, cancelled, no_show');
            $table->json('assessment_scores')->nullable()->comment('Structured scoring by criteria');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('result', 20)->nullable()->comment('passed, failed, pending');
            $table->timestamps();

            $table->index('application_id', 'idx_interview_app');
            $table->index('interviewer_id', 'idx_interview_interviewer');
            $table->index('scheduled_at', 'idx_interview_scheduled');
            $table->index('status', 'idx_interview_status');
        });

        // Background Checks
        Schema::create('background_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->string('referee_name');
            $table->string('referee_position')->nullable();
            $table->string('referee_company')->nullable();
            $table->string('referee_email')->nullable();
            $table->string('referee_phone', 50)->nullable();
            $table->string('form_token')->unique()->nullable();
            $table->timestamp('form_sent_at')->nullable();
            $table->foreignId('form_sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('form_completed_at')->nullable();
            $table->json('responses')->nullable()->comment('Structured questionnaire responses');
            $table->string('status', 20)->default('pending')->comment('pending, sent, completed, failed');
            $table->string('result', 20)->nullable()->comment('passed, failed, pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('application_id', 'idx_bgcheck_app');
            $table->unique('form_token', 'idx_bgcheck_token');
            $table->index('status', 'idx_bgcheck_status');
        });

        // Medical Checkups
        Schema::create('medical_checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained('applications')->onDelete('cascade');
            $table->timestamp('scheduled_at')->nullable();
            $table->foreignId('scheduled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('clinic_name')->nullable();
            $table->text('clinic_address')->nullable();
            $table->string('result_file_path')->nullable();
            $table->json('result_data')->nullable()->comment('Structured medical test results');
            $table->string('status', 20)->default('scheduled')->comment('scheduled, completed, failed');
            $table->string('result', 20)->nullable()->comment('fit, unfit, pending');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique('application_id', 'idx_mcu_app');
            $table->index('status', 'idx_mcu_status');
        });

        // Hiring Approvals
        Schema::create('hiring_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained('applications')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->string('status', 20)->default('pending')->comment('pending, approved, rejected');
            $table->string('offer_letter_path')->nullable();
            $table->timestamp('offer_sent_at')->nullable();
            $table->decimal('salary_offered', 15, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique('application_id', 'idx_hiring_app');
            $table->index('status', 'idx_hiring_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiring_approvals');
        Schema::dropIfExists('medical_checkups');
        Schema::dropIfExists('background_checks');
        Schema::dropIfExists('interviews');
        Schema::dropIfExists('psychotests');
        Schema::dropIfExists('administrative_selections');
    }
};
