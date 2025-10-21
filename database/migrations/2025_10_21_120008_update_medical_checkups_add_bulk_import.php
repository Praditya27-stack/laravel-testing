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
        Schema::table('medical_checkups', function (Blueprint $table) {
            // SCHEDULING (REVISED)
            $table->date('mcu_date')->nullable()->after('application_id');
            $table->string('mcu_location')->nullable()->after('mcu_date');
            $table->text('mcu_requirements')->nullable()->after('mcu_location')->comment('Syarat MCU (puasa, bawa KTP, dll)');
            $table->timestamp('invitation_sent_at')->nullable()->after('mcu_requirements');
            
            // BULK IMPORT
            $table->boolean('imported_from_excel')->default(false)->after('completed_at');
            $table->integer('excel_row_number')->nullable()->after('imported_from_excel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_checkups', function (Blueprint $table) {
            $table->dropColumn([
                'mcu_date',
                'mcu_location',
                'mcu_requirements',
                'invitation_sent_at',
                'imported_from_excel',
                'excel_row_number'
            ]);
        });
    }
};
