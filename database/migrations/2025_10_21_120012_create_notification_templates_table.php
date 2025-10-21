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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('type', 50)->comment('email, whatsapp, both');
            $table->string('stage', 50)->comment('psychotest_invite, interview_invite, mcu_invite, etc.');
            
            // EMAIL TEMPLATE
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable()->comment('HTML/Markdown template');
            
            // WHATSAPP TEMPLATE
            $table->text('whatsapp_message')->nullable();
            
            // PLACEHOLDER VARIABLES
            $table->json('available_variables')->nullable()->comment('{{name}}, {{date}}, {{link}}, {{job_title}}, etc.');
            
            // STATUS
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['stage', 'is_active'], 'idx_template_stage_active');
            $table->index('is_default', 'idx_template_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
