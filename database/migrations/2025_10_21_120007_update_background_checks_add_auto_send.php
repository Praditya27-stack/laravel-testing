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
        Schema::table('background_checks', function (Blueprint $table) {
            // AUTO-SEND
            $table->boolean('auto_send_enabled')->default(true)->after('form_completed_at');
            $table->date('link_expiry_date')->nullable()->after('auto_send_enabled');
            $table->integer('reminder_count')->default(0)->after('link_expiry_date');
            $table->timestamp('last_reminder_sent_at')->nullable()->after('reminder_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('background_checks', function (Blueprint $table) {
            $table->dropColumn([
                'auto_send_enabled',
                'link_expiry_date',
                'reminder_count',
                'last_reminder_sent_at'
            ]);
        });
    }
};
