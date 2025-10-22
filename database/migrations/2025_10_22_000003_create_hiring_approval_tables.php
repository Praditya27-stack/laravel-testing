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
        // Hiring Approval Requests Table
        Schema::create('hiring_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->string('approval_number', 50)->unique()->comment('Auto-generated: APR-YYYYMMDD-XXX');
            
            // Offer Details
            $table->decimal('salary_offered', 15, 2);
            $table->string('position_title');
            $table->string('department');
            $table->date('join_date');
            $table->date('briefing_date')->nullable();
            $table->enum('employment_type', ['permanent', 'contract', 'internship'])->default('permanent');
            $table->integer('contract_duration_months')->nullable();
            $table->text('benefits_package')->nullable();
            $table->text('additional_notes')->nullable();
            
            // Approval Flow
            $table->foreignId('approver_id')->constrained('users')->comment('PIC Recruitment');
            $table->enum('status', ['pending', 'approved', 'rejected', 'revision_needed'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('revision_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            
            // Document
            $table->string('approval_document_path')->nullable();
            
            // Requester
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['application_id', 'status'], 'idx_approval_app_status');
            $table->index('status', 'idx_approval_status');
            $table->index('approver_id', 'idx_approval_approver');
            $table->index('approval_number', 'idx_approval_number');
        });

        // Offer Letters Table
        Schema::create('offer_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('approval_request_id')->constrained('hiring_approval_requests')->onDelete('cascade');
            $table->string('offer_number', 50)->unique()->comment('Auto-generated: OFR-YYYYMMDD-XXX');
            
            // Offer Letter Content
            $table->text('offer_letter_content')->nullable()->comment('HTML content');
            $table->string('offer_letter_pdf_path')->nullable();
            
            // Offer Status
            $table->enum('status', ['draft', 'sent', 'accepted', 'declined'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->text('decline_reason')->nullable();
            
            // Response Deadline
            $table->date('response_deadline')->nullable();
            $table->integer('reminder_count')->default(0);
            $table->timestamp('last_reminder_at')->nullable();
            
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['application_id', 'status'], 'idx_offer_app_status');
            $table->index('status', 'idx_offer_status');
            $table->index('offer_number', 'idx_offer_number');
        });

        // Onboarding Information Table
        Schema::create('onboarding_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('offer_letter_id')->constrained('offer_letters')->onDelete('cascade');
            
            // Onboarding Details
            $table->date('onboarding_date');
            $table->time('onboarding_time')->nullable();
            $table->string('onboarding_location')->nullable();
            $table->text('required_documents')->nullable()->comment('JSON array');
            $table->text('onboarding_agenda')->nullable();
            $table->text('contact_person')->nullable();
            
            // Status
            $table->enum('status', ['scheduled', 'sent', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamp('info_sent_at')->nullable();
            $table->timestamp('onboarded_at')->nullable();
            $table->boolean('is_archived')->default(false);
            
            $table->timestamps();

            $table->index('application_id', 'idx_onboarding_app');
            $table->index('status', 'idx_onboarding_status');
            $table->index('onboarding_date', 'idx_onboarding_date');
        });

        // Hired Candidates Export Log Table
        Schema::create('hired_export_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('export_type', ['excel', 'realta'])->comment('Export format type');
            $table->string('file_path');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->integer('total_records');
            $table->json('exported_fields')->nullable();
            $table->foreignId('exported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('export_type', 'idx_export_type');
            $table->index('exported_by', 'idx_export_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hired_export_logs');
        Schema::dropIfExists('onboarding_info');
        Schema::dropIfExists('offer_letters');
        Schema::dropIfExists('hiring_approval_requests');
    }
};
