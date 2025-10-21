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
        // B1: Formal Education
        Schema::create('formal_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('level', 10)->comment('SD, SLTP, SMA, SMK');
            $table->string('school_name');
            $table->string('major')->nullable()->comment('Jurusan - NULL for SD/SLTP');
            $table->integer('graduation_year');
            $table->string('location')->nullable();
            $table->decimal('math_avg_semester', 4, 2)->nullable()->comment('Average math score semester 1-6');
            $table->decimal('math_un_score', 4, 2)->nullable()->comment('National exam math score');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_formal_edu_user');
            $table->index(['user_id', 'level'], 'idx_user_edu_level');
        });

        // B2: Non-Formal Education
        Schema::create('non_formal_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('course_name');
            $table->string('location')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_nonformal_edu_user');
        });

        // B3: Language Skills
        Schema::create('language_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('language_name', 100);
            $table->string('writing_skill', 10)->comment('baik, kurang');
            $table->string('reading_skill', 10)->comment('baik, kurang');
            $table->string('grammar_skill', 10)->comment('baik, kurang');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_language_user');
        });

        // B4: Organization Experiences
        Schema::create('organization_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('organization_name');
            $table->string('location')->nullable();
            $table->string('position')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_org_exp_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_experiences');
        Schema::dropIfExists('language_skills');
        Schema::dropIfExists('non_formal_educations');
        Schema::dropIfExists('formal_educations');
    }
};
