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
        Schema::create('recruitment_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained('jobs')->nullOnDelete();
            
            // TIME PERIOD
            $table->date('month')->comment('YYYY-MM-01 format');
            
            // METRICS
            $table->integer('total_applicants')->default(0);
            $table->integer('passed_administrative')->default(0);
            $table->integer('passed_psychotest')->default(0);
            $table->integer('passed_hr_interview')->default(0);
            $table->integer('passed_user_interview')->default(0);
            $table->integer('passed_background_check')->default(0);
            $table->integer('passed_medical_checkup')->default(0);
            $table->integer('reached_offering')->default(0);
            $table->integer('hired_count')->default(0);
            
            // EDUCATION BREAKDOWN (For Charts)
            $table->json('applicants_by_school')->nullable()->comment('SMK school distribution');
            $table->json('applicants_by_university')->nullable()->comment('D3/S1 university distribution');
            
            // SOURCE TRACKING
            $table->json('applicants_by_source')->nullable()->comment('website, linkedin, referral, etc.');
            
            $table->timestamps();
            
            $table->unique(['job_id', 'month'], 'idx_analytics_job_month');
            $table->index('month', 'idx_analytics_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_analytics');
    }
};
