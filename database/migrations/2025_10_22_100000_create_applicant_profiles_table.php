<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Applicant Profile - Main Info (only if doesn't exist)
        if (!Schema::hasTable('applicant_profiles')) {
            Schema::create('applicant_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                
                // Personal Info (30%)
                $table->string('full_name')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('province')->nullable();
                $table->string('postal_code')->nullable();
                $table->date('birth_date')->nullable();
                $table->string('birth_place')->nullable();
                $table->enum('gender', ['male', 'female'])->nullable();
                $table->enum('marital_status', ['single', 'married', 'divorced'])->nullable();
                $table->string('religion')->nullable();
                $table->string('nationality')->default('Indonesian');
                $table->string('id_card_number')->nullable(); // KTP
                
                // Profile completion tracking
                $table->integer('completion_percentage')->default(0);
                $table->json('completed_sections')->nullable(); // Track which sections are complete
                
                $table->timestamps();
            });
        }

        // Education History (20%) - Skip if exists
        if (!Schema::hasTable('applicant_educations')) {
            Schema::create('applicant_educations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->enum('level', ['sma', 'smk', 'd3', 's1', 's2', 's3']);
                $table->string('institution_name');
                $table->string('major')->nullable();
                $table->string('gpa')->nullable();
                $table->year('start_year');
                $table->year('end_year')->nullable();
                $table->boolean('is_current')->default(false);
                $table->timestamps();
            });
        }

        // Work Experience (20%) - Skip if exists
        if (!Schema::hasTable('applicant_experiences')) {
            Schema::create('applicant_experiences', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('company_name');
                $table->string('position');
                $table->text('job_description')->nullable();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->boolean('is_current')->default(false);
                $table->string('reason_leaving')->nullable();
                $table->timestamps();
            });
        }

        // Skills - Skip if exists (already exists from old migration)
        // applicant_skills table already exists, skip creation

        // Certifications (10%)
        if (!Schema::hasTable('applicant_certifications')) {
            Schema::create('applicant_certifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('certification_name');
                $table->string('issuing_organization');
                $table->date('issue_date');
                $table->date('expiry_date')->nullable();
                $table->string('credential_id')->nullable();
                $table->timestamps();
            });
        }

        // Documents - Skip if exists
        // applicant_documents table might exist, check first
        if (!Schema::hasTable('applicant_documents')) {
            Schema::create('applicant_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->enum('document_type', ['cv', 'ktp', 'ijazah', 'transkrip', 'sertifikat', 'foto', 'skck', 'other']);
                $table->string('file_path');
                $table->string('original_filename');
                $table->integer('file_size');
                $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
                $table->text('rejection_reason')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
            });
        }

        // References - Skip if exists (application_referees might already exist)
        if (!Schema::hasTable('applicant_references')) {
            Schema::create('applicant_references', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('relationship'); // Former supervisor, colleague, etc
                $table->string('company');
                $table->string('position');
                $table->string('phone');
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_references');
        Schema::dropIfExists('applicant_documents');
        Schema::dropIfExists('applicant_certifications');
        // Don't drop applicant_skills - it's from old migration
        Schema::dropIfExists('applicant_experiences');
        Schema::dropIfExists('applicant_educations');
        Schema::dropIfExists('applicant_profiles');
    }
};
