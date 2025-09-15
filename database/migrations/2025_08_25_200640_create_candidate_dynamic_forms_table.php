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
        Schema::create('candidate_dynamic_forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->string('background_image')->nullable();
            $table->string('note', 2000)->nullable();
            $table->enum('status', ['Enabled', 'Inactive'])->default('Enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_dynamic_forms');
    }
};
