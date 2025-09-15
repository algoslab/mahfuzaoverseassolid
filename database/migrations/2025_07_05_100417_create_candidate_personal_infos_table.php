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
        Schema::create('candidate_personal_infos', function (Blueprint $table) {
            $table->id();

            // Candidate relation
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            
            // Basic Personal Info
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('gender_id')->nullable()->constrained('genders')->onDelete('set null');
            $table->date('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('contact_person_number')->nullable();

            // Identity & Family
            $table->string('nid_or_birth_certificate')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();

            // Marital Info
            $table->enum('marital_status', ['single', 'married', 'seperated', 'widowed', 'not_specified'])->nullable();
            $table->string('spouse_name')->nullable();

            // Nominee
            $table->string('nominee_name')->nullable();
            $table->foreignId('relation_with_nominee_id')->nullable()->constrained('relations')->onDelete('set null');

            // Other Info
            $table->foreignId('religion_id')->nullable()->constrained('religions')->onDelete('set null');
            $table->foreignId('blood_group_id')->nullable()->constrained('blood_groups')->onDelete('set null');
            $table->longText('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_personal_infos');
    }
};
