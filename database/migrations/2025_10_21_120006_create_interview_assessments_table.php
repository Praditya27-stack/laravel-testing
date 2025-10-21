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
        Schema::create('interview_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->onDelete('cascade');
            $table->foreignId('assessor_id')->constrained('users')->onDelete('cascade');
            
            // ASSESSMENT CRITERIA (Customizable)
            $table->integer('technical_competence')->nullable()->comment('1-10');
            $table->integer('communication_skills')->nullable();
            $table->integer('problem_solving')->nullable();
            $table->integer('cultural_fit')->nullable();
            $table->integer('attitude')->nullable();
            $table->integer('overall_impression')->nullable();
            
            // QUALITATIVE
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('final_decision', 20)->nullable();
            
            $table->timestamp('assessed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['interview_id', 'assessor_id'], 'idx_interview_assessor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_assessments');
    }
};
