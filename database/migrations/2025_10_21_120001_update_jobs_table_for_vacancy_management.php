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
        Schema::table('jobs', function (Blueprint $table) {
            // GENERAL INFORMATION
            $table->date('publish_date')->nullable()->after('code');
            $table->date('end_date')->nullable()->after('publish_date');
            
            // VACANCY INFORMATION
            $table->string('vacancy_title')->nullable()->after('end_date');
            $table->string('position', 100)->nullable()->after('vacancy_title')->comment('PKL/Magang, Operator, Staff, Leader, Supervisor, Section Head, Manager, GM');
            $table->string('education_level', 20)->nullable()->after('position')->comment('SMK/SMA, D3, S1');
            $table->string('category', 50)->nullable()->after('education_level')->comment('Mahasiswa Aktif, Fresh Graduate, Professional, All');
            $table->string('function', 100)->nullable()->after('category')->comment('Engineering, Production, MIS/IT, HC, Marketing, Finance, etc.');
            $table->string('company', 100)->nullable()->after('function')->comment('PT Aisin Indonesia, PT Aisin Indonesia Automotive');
            
            // JOB DESCRIPTION
            $table->json('skills_required')->nullable()->after('description')->comment('Array of required skills');
            $table->integer('total_needed')->nullable()->after('skills_required')->comment('Jumlah kebutuhan');
            
            // SELECTION PROCESS TYPE (CRITICAL!)
            $table->string('selection_type', 20)->nullable()->after('total_needed')->comment('operator_smk, staff_d3s1');
            
            // Add indexes
            $table->index(['selection_type', 'status'], 'idx_job_type_status');
            $table->index(['publish_date', 'end_date'], 'idx_job_dates');
            $table->index('education_level', 'idx_job_edu');
            $table->index('function', 'idx_job_function');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex('idx_job_type_status');
            $table->dropIndex('idx_job_dates');
            $table->dropIndex('idx_job_edu');
            $table->dropIndex('idx_job_function');
            
            $table->dropColumn([
                'publish_date',
                'end_date',
                'vacancy_title',
                'position',
                'education_level',
                'category',
                'function',
                'company',
                'skills_required',
                'total_needed',
                'selection_type'
            ]);
        });
    }
};
