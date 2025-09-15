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
        Schema::create('candidate_files', function (Blueprint $table) {
            $table->id();

            // Candidate relation
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');

            $table->string('candidate_photo')->nullable();
            $table->string('police_verification')->nullable();
            $table->string('other_certification')->nullable();
            $table->string('optional_file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_files');
    }
};
