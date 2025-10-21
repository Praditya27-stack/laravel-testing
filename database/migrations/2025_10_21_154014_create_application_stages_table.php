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
        Schema::create('application_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->string('stage_name'); // administrative, psychotest, hr_interview, user_interview, background_check, mcu, offering
            $table->integer('stage_order'); // 1, 2, 3, 4, 5, 6, 7
            $table->enum('status', ['pending', 'in_progress', 'passed', 'failed', 'on_hold'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->json('documents_requested')->nullable(); // For requesting more documents
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['application_id', 'stage_order']);
            $table->index(['stage_name', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_stages');
    }
};
