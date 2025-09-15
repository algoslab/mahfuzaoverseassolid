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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_type_id')->nullable()->constrained('candidate_types')->onDelete('set null');
            $table->foreignId('referral_agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->foreignId('interested_country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('interested_profession_id')->nullable()->constrained('professions')->onDelete('set null');
            $table->string('nationality')->nullable();
            $table->longText('note')->nullable();
            $table->longText('comments')->nullable();
            $table->decimal('commission', 10, 2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
