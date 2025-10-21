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
        Schema::table('psychotests', function (Blueprint $table) {
            // TEST EXECUTION (FOR MONITORING)
            $table->timestamp('test_expiry_at')->nullable()->after('test_scheduled_at')->comment('Max 2 hari setelah dikirim');
            $table->timestamp('test_started_at')->nullable()->after('test_location');
            $table->timestamp('test_last_activity_at')->nullable()->after('test_started_at');
            $table->boolean('is_currently_taking')->default(false)->after('test_last_activity_at');
            
            // RESULTS
            $table->decimal('passing_grade', 5, 2)->nullable()->after('result_file_path');
            $table->boolean('is_passed')->nullable()->after('passing_grade')->comment('Auto-calculated: result >= passing_grade');
            
            // Add indexes
            $table->index('is_currently_taking', 'idx_psycho_ongoing');
            $table->index(['application_id', 'test_type'], 'idx_app_test_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psychotests', function (Blueprint $table) {
            $table->dropIndex('idx_psycho_ongoing');
            $table->dropIndex('idx_app_test_type');
            
            $table->dropColumn([
                'test_expiry_at',
                'test_started_at',
                'test_last_activity_at',
                'is_currently_taking',
                'passing_grade',
                'is_passed'
            ]);
        });
    }
};
