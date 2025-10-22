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
        Schema::create('application_referees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            
            // Referee Information
            $table->string('name');
            $table->string('relationship')->comment('Former Supervisor, Colleague, Manager, etc.');
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('phone_alt')->nullable()->comment('Alternative phone number');
            
            // Work Period
            $table->date('work_period_start')->nullable();
            $table->date('work_period_end')->nullable();
            
            // Status
            $table->boolean('is_primary')->default(false)->comment('Primary referee');
            $table->boolean('is_verified')->default(false)->comment('Contact verified by HR');
            $table->text('notes')->nullable();
            
            $table->timestamps();

            $table->index('application_id', 'idx_referee_application');
            $table->index('email', 'idx_referee_email');
            $table->index('is_primary', 'idx_referee_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_referees');
    }
};
