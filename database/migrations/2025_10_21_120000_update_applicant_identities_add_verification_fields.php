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
        Schema::table('applicant_identities', function (Blueprint $table) {
            // NIK & VERIFICATION
            $table->timestamp('nik_verified_at')->nullable()->after('national_id_number')->comment('Verified with Disdukcapil API');
            $table->boolean('birth_date_verified')->default(false)->after('nik_verified_at');
            
            // DISABILITY & HEALTH
            $table->boolean('has_disability')->default(false)->after('birth_date_verified');
            $table->string('disability_type')->nullable()->after('has_disability');
            $table->boolean('is_colorblind')->default(false)->after('disability_type');
            $table->boolean('has_vision_correction')->default(false)->after('is_colorblind');
            $table->string('vision_details')->nullable()->after('has_vision_correction')->comment('Plus/minus details');
            
            // Add index for nik_verified_at
            $table->index('nik_verified_at', 'idx_nik_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_identities', function (Blueprint $table) {
            $table->dropIndex('idx_nik_verified');
            $table->dropColumn([
                'nik_verified_at',
                'birth_date_verified',
                'has_disability',
                'disability_type',
                'is_colorblind',
                'has_vision_correction',
                'vision_details'
            ]);
        });
    }
};
