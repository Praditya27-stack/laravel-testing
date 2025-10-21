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
        // Psychotest Invitations
        Schema::create('psychotest_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->string('education_level'); // SMK, D3, S1
            $table->json('test_types'); // Array of test types
            $table->string('test_location'); // online, onsite
            $table->dateTime('scheduled_at');
            $table->dateTime('expires_at');
            $table->integer('passing_grade')->default(70);
            $table->string('unique_token')->unique();
            $table->string('test_link');
            $table->string('guide_pdf_path')->nullable();
            $table->string('hotline_contact')->nullable();
            $table->enum('status', ['pending', 'sent', 'opened', 'started', 'completed', 'expired'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['application_id', 'status']);
            $table->index('unique_token');
        });

        // Psychotest Sessions (for monitoring ongoing tests)
        Schema::create('psychotest_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('psychotest_invitations')->onDelete('cascade');
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->string('test_type'); // WPT, Army Alpha, Papikostick, SSCT, Kraeplin, Inteligensi, Kepribadian, Perilaku
            $table->timestamp('started_at');
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->enum('status', ['in_progress', 'paused', 'idle', 'completed', 'abandoned'])->default('in_progress');
            $table->json('answers')->nullable();
            $table->integer('score')->nullable();
            $table->boolean('is_passed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['invitation_id', 'status']);
            $table->index('status');
        });

        // Psychotest Results
        Schema::create('psychotest_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('invitation_id')->constrained('psychotest_invitations')->onDelete('cascade');
            $table->string('test_type');
            $table->integer('raw_score');
            $table->integer('final_score');
            $table->boolean('is_passed');
            $table->string('grade')->nullable(); // A, B, C, D, E
            $table->text('interpretation')->nullable();
            $table->string('psikogram_pdf_path')->nullable();
            $table->json('detailed_scores')->nullable(); // Breakdown per section
            $table->text('notes')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            $table->index(['application_id', 'test_type']);
            $table->index('is_passed');
        });

        // Psychotest Retest Requests
        Schema::create('psychotest_retests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('original_invitation_id')->constrained('psychotest_invitations')->onDelete('cascade');
            $table->string('reason');
            $table->text('notes')->nullable();
            $table->foreignId('requested_by')->constrained('users');
            $table->timestamp('requested_at');
            $table->foreignId('new_invitation_id')->nullable()->constrained('psychotest_invitations');
            $table->enum('status', ['pending', 'approved', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotest_retests');
        Schema::dropIfExists('psychotest_results');
        Schema::dropIfExists('psychotest_sessions');
        Schema::dropIfExists('psychotest_invitations');
    }
};
