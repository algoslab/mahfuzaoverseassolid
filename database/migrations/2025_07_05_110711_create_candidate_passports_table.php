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
        Schema::create('candidate_passports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');

             // Passport Info
            $table->enum('passport_type', ['no_passport', 'ordinary', 'official', 'diplomatic', 'special'])->nullable();
            $table->string('passport_number')->unique();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expired_date')->nullable();

            // District
            $table->foreignId('passport_issue_place_id')->nullable()->constrained('districts')->onDelete('set null');

            // Validity year
            $table->integer('validity_years')->nullable();

            // File path of scan copy
            $table->string('passport_scan_copy')->nullable();

            // Note
            $table->longText('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_passports');
    }
};
