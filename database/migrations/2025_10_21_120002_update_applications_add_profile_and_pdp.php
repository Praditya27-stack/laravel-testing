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
        Schema::table('applications', function (Blueprint $table) {
            // PROFILE COMPLETION
            $table->integer('profile_completion_percentage')->default(0)->after('current_stage')->comment('0-100%');
            
            // PDP CONSENT (REQUIRED!)
            $table->boolean('pdp_consent_given')->default(false)->after('profile_completion_percentage');
            $table->timestamp('pdp_consent_at')->nullable()->after('pdp_consent_given');
            
            // Add indexes
            $table->index('profile_completion_percentage', 'idx_profile_complete');
            $table->index('pdp_consent_given', 'idx_pdp_consent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex('idx_profile_complete');
            $table->dropIndex('idx_pdp_consent');
            
            $table->dropColumn([
                'profile_completion_percentage',
                'pdp_consent_given',
                'pdp_consent_at'
            ]);
        });
    }
};
