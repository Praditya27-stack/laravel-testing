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
        // Jobs Table
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique()->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('employment_type', 50)->nullable()->comment('full_time, part_time, contract, internship');
            $table->string('seniority', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('salary_range')->nullable();
            $table->foreignId('hiring_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('closing_at')->nullable();
            $table->string('status', 20)->default('draft')->comment('draft, open, closed');
            $table->timestamps();

            $table->unique('slug', 'idx_job_slug');
            $table->index('status', 'idx_job_status');
            $table->index(['department', 'location'], 'idx_job_dept_loc');
            $table->index('posted_at', 'idx_job_posted');
        });

        // Applications Table
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('application_number', 50)->unique()->comment('Auto-generated: APP-YYYYMMDD-XXX');
            $table->string('current_stage', 50)->default('applied')->comment('applied, administrative, psychotest, interview, background_check, medical_checkup, hiring_approval, rejected, hired');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('hired_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('source', 100)->nullable()->comment('website, linkedin, referral, etc.');
            $table->text('cover_letter')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique('application_number', 'idx_app_number');
            $table->index(['job_id', 'user_id'], 'idx_job_user');
            $table->index('current_stage', 'idx_app_stage');
            $table->index('applied_at', 'idx_app_applied');
        });

        // Application Stage Histories
        Schema::create('application_stage_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->string('from_stage', 50)->nullable();
            $table->string('to_stage', 50);
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->index('application_id', 'idx_stage_history_app');
            $table->index(['application_id', 'changed_at'], 'idx_app_changed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_stage_histories');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('jobs');
    }
};
