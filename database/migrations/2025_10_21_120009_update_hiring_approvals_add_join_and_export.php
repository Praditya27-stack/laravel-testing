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
        Schema::table('hiring_approvals', function (Blueprint $table) {
            // APPROVAL TRACKING (REVISED)
            $table->string('approval_requested_to')->nullable()->after('approved_by')->comment('PIC Recruitment name');
            $table->string('approval_document_path', 500)->nullable()->after('approval_requested_to')->comment('PDF for signature');
            
            // JOIN & BRIEFING
            $table->date('join_date')->nullable()->after('salary_offered');
            $table->date('briefing_date')->nullable()->after('join_date');
            
            // EXPORT
            $table->boolean('exported_to_realta_format')->default(false)->after('briefing_date');
            $table->timestamp('exported_at')->nullable()->after('exported_to_realta_format');
            $table->foreignId('exported_by')->nullable()->constrained('users')->nullOnDelete()->after('exported_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiring_approvals', function (Blueprint $table) {
            $table->dropForeign(['exported_by']);
            $table->dropColumn([
                'approval_requested_to',
                'approval_document_path',
                'join_date',
                'briefing_date',
                'exported_to_realta_format',
                'exported_at',
                'exported_by'
            ]);
        });
    }
};
