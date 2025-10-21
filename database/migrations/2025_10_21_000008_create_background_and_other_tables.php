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
        // F: Background Check Referees
        Schema::create('background_check_referees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('referee_name');
            $table->string('department_position')->nullable();
            $table->string('company_name')->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_referee_user');
        });

        // G1: Previous Applications
        Schema::create('previous_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('organizer')->nullable()->comment('Who organized the previous application');
            $table->string('process_stage', 50)->nullable()->comment('administrasi, psikotes, interview_hrd, interview_user, mcu, lainnya');
            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_prev_app_user');
        });

        // G2-G3: Hobbies
        Schema::create('applicant_hobbies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->text('hobbies')->nullable()->comment('Free text or JSON array of hobbies');
            $table->text('free_time_activity')->nullable()->comment('How applicant spends free time');
            $table->timestamps();

            $table->unique('user_id', 'idx_hobby_user');
        });

        // G4-G5: Strengths and Weaknesses
        Schema::create('applicant_strengths_weaknesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type', 20)->comment('strength or weakness');
            $table->text('description');
            $table->integer('order_number')->comment('1, 2, 3, ... (minimum 3 each)');
            $table->timestamps();

            $table->index('user_id', 'idx_strength_weak_user');
            $table->unique(['user_id', 'type', 'order_number'], 'idx_user_type_order');
        });

        // G6: Medical History
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('disease_name');
            $table->string('is_active', 20)->comment('ya, tidak, sudah_tidak');
            $table->date('suffered_since')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_medical_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
        Schema::dropIfExists('applicant_strengths_weaknesses');
        Schema::dropIfExists('applicant_hobbies');
        Schema::dropIfExists('previous_applications');
        Schema::dropIfExists('background_check_referees');
    }
};
