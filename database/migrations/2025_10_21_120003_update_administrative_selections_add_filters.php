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
        Schema::table('administrative_selections', function (Blueprint $table) {
            // FILTER & SORT CRITERIA
            $table->json('filter_criteria')->nullable()->after('status')->comment('Applied filters (age, education, GPA, etc.)');
            $table->string('sort_by', 50)->nullable()->after('filter_criteria')->comment('nama, terbaru, gpa, pengalaman, usia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrative_selections', function (Blueprint $table) {
            $table->dropColumn(['filter_criteria', 'sort_by']);
        });
    }
};
