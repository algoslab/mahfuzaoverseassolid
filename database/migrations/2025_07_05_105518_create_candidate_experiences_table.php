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
        Schema::create('candidate_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');

            $table->enum('experience_type', ['fresher', 'experienced'])->default('fresher');

            $table->string('company_name')->nullable();
            $table->longText('old_company_address')->nullable();

            $table->foreignId('work_type_id')->nullable()->constrained('professions')->onDelete('set null');

            $table->date('departure_date')->nullable();
            $table->date('arrival_date')->nullable();

            $table->string('departure_seal')->nullable();
            $table->string('arrival_seal')->nullable();

            $table->json('travelled_country_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_experiences');
    }
};
