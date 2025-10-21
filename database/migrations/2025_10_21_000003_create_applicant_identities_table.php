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
        Schema::create('applicant_identities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->json('driving_license_types')->nullable()->comment('Array of license types: ["A","B","C"]');
            $table->string('driving_license_number', 50)->nullable();
            $table->string('national_id_number', 50)->unique()->comment('NIK / KTP number');
            $table->string('phone_number', 20);
            $table->text('address_ktp');
            $table->text('address_domicile');
            $table->string('parent_phone', 20)->nullable();
            $table->string('email');
            $table->string('religion', 50)->comment('islam, kristen, katolik, hindu, buddha, konghucu, lainnya');
            $table->char('gender', 1)->comment('L or P');
            $table->string('blood_type', 3)->nullable()->comment('A, B, AB, O');
            $table->integer('height_cm')->nullable();
            $table->integer('weight_kg')->nullable();
            $table->string('shirt_size', 10)->nullable()->comment('M, L, XL, XXL, XXXL');
            $table->integer('pants_size')->nullable()->comment('Size range 28-35');
            $table->integer('shoe_size')->nullable()->comment('Size range 37-48');
            $table->string('photo_path', 500)->nullable();
            $table->timestamps();

            $table->unique('national_id_number', 'idx_national_id');
            $table->index(['user_id', 'national_id_number'], 'idx_user_nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_identities');
    }
};
