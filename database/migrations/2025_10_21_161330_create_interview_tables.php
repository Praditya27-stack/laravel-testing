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
        // Interview Reminders Log (new table)
        Schema::create('interview_reminders_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->onDelete('cascade');
            $table->enum('reminder_type', ['h_minus_1', 'h_minus_3', 'manual']);
            $table->enum('channel', ['email', 'whatsapp', 'both'])->default('both');
            $table->timestamp('sent_at');
            $table->boolean('is_successful')->default(true);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        // Update existing interview_assessments if needed
        if (!Schema::hasTable('interview_assessments')) {
            Schema::create('interview_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('assessor_id')->constrained('users'); // Interviewer who assessed
            $table->string('assessor_role'); // interviewer, dept_user
            
            // Scoring (1-10 scale)
            $table->integer('technical_competence')->nullable();
            $table->integer('communication_skills')->nullable();
            $table->integer('problem_solving')->nullable();
            $table->integer('cultural_fit')->nullable();
            $table->integer('attitude')->nullable();
            $table->integer('overall_impression')->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            
            // Qualitative feedback
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('recommendation')->nullable();
            
            // Decision
            $table->enum('decision', ['passed', 'failed', 'pending'])->default('pending');
            $table->text('decision_notes')->nullable();
            
            // Override by HR
            $table->boolean('is_overridden')->default(false);
            $table->foreignId('overridden_by')->nullable()->constrained('users');
            $table->text('override_reason')->nullable();
            $table->timestamp('overridden_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['application_id', 'decision']);
            $table->index('assessor_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_reminders_log');
    }
};
