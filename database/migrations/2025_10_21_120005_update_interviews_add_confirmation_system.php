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
        Schema::table('interviews', function (Blueprint $table) {
            // CANDIDATE CONFIRMATION
            $table->boolean('candidate_confirmed')->nullable()->after('duration_minutes');
            $table->boolean('candidate_declined')->nullable()->after('candidate_confirmed');
            $table->text('decline_reason')->nullable()->after('candidate_declined');
            $table->timestamp('confirmed_at')->nullable()->after('decline_reason');
            
            // ICS CALENDAR
            $table->string('ics_file_path', 500)->nullable()->after('confirmed_at');
            
            // REMINDER
            $table->timestamp('reminder_sent_at')->nullable()->after('ics_file_path');
            
            // Add indexes
            $table->index(['application_id', 'interview_type'], 'idx_app_interview_type');
            $table->index(['scheduled_at', 'status'], 'idx_interview_schedule');
            $table->index('candidate_confirmed', 'idx_interview_confirmed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropIndex('idx_app_interview_type');
            $table->dropIndex('idx_interview_schedule');
            $table->dropIndex('idx_interview_confirmed');
            
            $table->dropColumn([
                'candidate_confirmed',
                'candidate_declined',
                'decline_reason',
                'confirmed_at',
                'ics_file_path',
                'reminder_sent_at'
            ]);
        });
    }
};
