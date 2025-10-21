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
        Schema::create('candidate_pool', function (Blueprint $table) {
            $table->id();
            
            // BASIC INFO
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone_number', 20);
            $table->string('national_id_number', 50)->unique();
            
            // SOURCE
            $table->string('source_type', 50)->comment('referral, walk_in, headhunt, etc.');
            $table->string('referred_by')->nullable();
            $table->foreignId('referred_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // QUICK PROFILE
            $table->string('education_level', 20)->nullable();
            $table->string('latest_school')->nullable();
            $table->string('latest_position')->nullable();
            $table->string('latest_company')->nullable();
            
            // CV ATTACHMENT
            $table->string('cv_path', 500)->nullable();
            
            // CONVERSION STATUS
            $table->boolean('is_converted_to_user')->default(false);
            $table->foreignId('converted_user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // TAGGING & FILTERING
            $table->json('tags')->nullable()->comment('Array of tags');
            
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('email', 'idx_pool_email');
            $table->index('national_id_number', 'idx_pool_nik');
            $table->index('source_type', 'idx_pool_source');
            $table->index('is_converted_to_user', 'idx_pool_converted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_pool');
    }
};
