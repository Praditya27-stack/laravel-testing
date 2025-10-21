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
        // C1: Marital Status
        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('status_ktp', 20)->comment('single, engaged, married, divorced');
            $table->string('status_actual', 20)->comment('single, engaged, married, divorced');
            $table->date('status_date')->nullable()->comment('Date of engagement/marriage/divorce');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique('user_id', 'idx_marital_user');
        });

        // C2: Spouse and Children
        Schema::create('spouses_and_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('relation_type', 20)->comment('spouse, child1, child2, child3, ...');
            $table->string('name');
            $table->char('gender', 1)->comment('L or P');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_spouse_children_user');
            $table->index(['user_id', 'relation_type'], 'idx_user_relation');
        });

        // C3: Family Members (Parents, Siblings)
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('relation_type', 20)->comment('father, mother, child1, child2, ...');
            $table->string('name');
            $table->char('gender', 1)->comment('L or P');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_family_user');
            $table->index(['user_id', 'relation_type'], 'idx_user_family_relation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
        Schema::dropIfExists('spouses_and_children');
        Schema::dropIfExists('marital_statuses');
    }
};
