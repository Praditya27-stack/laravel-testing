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
        // Background Check Requests Table
        Schema::create('background_check_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('referee_id')->constrained('application_referees')->onDelete('cascade');
            $table->string('token', 100)->unique()->comment('Unique token for form access');
            $table->string('form_link')->comment('Full URL to BGC form');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('link_expiry_date');
            $table->enum('status', ['pending', 'sent', 'completed', 'expired'])->default('pending');
            $table->enum('send_method', ['email', 'whatsapp', 'both'])->default('email');
            $table->integer('reminder_count')->default(0);
            $table->timestamp('last_reminder_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['application_id', 'status'], 'idx_bgc_request_app_status');
            $table->index('token', 'idx_bgc_request_token');
            $table->index('link_expiry_date', 'idx_bgc_request_expiry');
        });

        // Background Check Responses Table
        Schema::create('background_check_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('background_check_requests')->onDelete('cascade');
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            
            // Questionnaire Responses (1-5 scale)
            $table->string('duration_known')->nullable()->comment('How long known the candidate');
            $table->integer('rating_work_performance')->nullable()->comment('1-5 scale');
            $table->integer('rating_attendance')->nullable()->comment('1-5 scale');
            $table->integer('rating_teamwork')->nullable()->comment('1-5 scale');
            $table->integer('rating_integrity')->nullable()->comment('1-5 scale');
            $table->integer('rating_communication')->nullable()->comment('1-5 scale');
            $table->integer('rating_problem_solving')->nullable()->comment('1-5 scale');
            $table->enum('would_recommend', ['yes', 'no', 'maybe'])->nullable();
            $table->text('reason_for_leaving')->nullable();
            $table->text('additional_comments')->nullable();
            
            // Calculated Fields
            $table->decimal('average_rating', 3, 2)->nullable()->comment('Average of all ratings');
            $table->integer('total_score')->nullable()->comment('Sum of all ratings');
            
            // Metadata
            $table->string('referee_ip_address', 45)->nullable();
            $table->text('referee_user_agent')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->index('request_id', 'idx_bgc_response_request');
            $table->index('application_id', 'idx_bgc_response_app');
            $table->index('average_rating', 'idx_bgc_response_rating');
        });

        // Background Check Results Table (HR Assessment)
        Schema::create('background_check_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('response_id')->nullable()->constrained('background_check_responses')->nullOnDelete();
            
            // HR Assessment
            $table->enum('result', ['passed', 'failed', 'pending', 'need_more_info'])->default('pending');
            $table->text('hr_notes')->nullable();
            $table->text('additional_info')->nullable()->comment('From follow-up calls');
            
            // System Suggestion
            $table->enum('system_suggestion', ['pass', 'fail', 'review'])->nullable();
            $table->text('suggestion_reason')->nullable();
            
            // Decision Maker
            $table->foreignId('assessed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assessed_at')->nullable();
            
            $table->timestamps();

            $table->index(['application_id', 'result'], 'idx_bgc_result_app_result');
            $table->index('result', 'idx_bgc_result_result');
        });

        // Background Check Follow-ups Table
        Schema::create('background_check_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('background_check_requests')->onDelete('cascade');
            $table->enum('action_type', ['reminder_sent', 'expiry_extended', 'referee_changed', 'phone_call', 'email_sent', 'whatsapp_sent'])->comment('Type of follow-up action');
            $table->text('notes')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('performed_at')->useCurrent();
            $table->timestamps();

            $table->index('request_id', 'idx_bgc_followup_request');
            $table->index('action_type', 'idx_bgc_followup_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('background_check_followups');
        Schema::dropIfExists('background_check_results');
        Schema::dropIfExists('background_check_responses');
        Schema::dropIfExists('background_check_requests');
    }
};
