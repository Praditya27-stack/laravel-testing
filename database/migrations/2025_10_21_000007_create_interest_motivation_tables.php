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
        // E1: Skills
        Schema::create('applicant_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('skill_name')->comment('welding, forklift, ms_office, autocad, etc.');
            $table->string('proficiency_level', 20)->nullable()->comment('beginner, intermediate, advanced, expert');
            $table->timestamps();

            $table->index('user_id', 'idx_skills_user');
            $table->index(['user_id', 'skill_name'], 'idx_user_skill');
        });

        // E2-E6: Motivations
        Schema::create('applicant_motivations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->text('q2_motivation')->nullable()->comment('Apa yang mendorong anda ingin bekerja?');
            $table->text('q3_why_company')->nullable()->comment('Mengapa ingin bekerja di perusahaan kami?');
            $table->decimal('q4_expected_salary', 15, 2)->nullable()->comment('Gaji yang diinginkan');
            $table->date('q5_available_start_date')->nullable()->comment('Kapan bisa mulai bekerja');
            $table->boolean('q6_has_referral')->default(false);
            $table->string('q6_referral_name')->nullable();
            $table->string('q6_referral_relation')->nullable()->comment('Hubungan dengan referral');
            $table->timestamps();

            $table->unique('user_id', 'idx_motivation_user');
        });

        // E7: Department Preferences
        Schema::create('department_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('department_name');
            $table->integer('priority_order')->comment('Priority 1, 2, or 3');
            $table->timestamps();

            $table->index('user_id', 'idx_dept_pref_user');
            $table->unique(['user_id', 'priority_order'], 'idx_user_priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_preferences');
        Schema::dropIfExists('applicant_motivations');
        Schema::dropIfExists('applicant_skills');
    }
};
