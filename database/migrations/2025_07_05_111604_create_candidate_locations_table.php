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
        Schema::create('candidate_locations', function (Blueprint $table) {
            $table->id();

            // Candidate relation
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');

            // Location Info
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->constrained('districts')->onDelete('set null');
            $table->foreignId('thana_id')->nullable()->constrained('thanas')->onDelete('set null');
            $table->foreignId('post_office_id')->nullable()->constrained('post_offices')->onDelete('set null');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');

            $table->longText('current_address')->nullable();
            $table->longText('permanent_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_locations');
    }
};
