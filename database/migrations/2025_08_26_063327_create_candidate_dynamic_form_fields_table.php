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
        Schema::create('candidate_dynamic_form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_dynamic_form_id');
            $table->foreign('candidate_dynamic_form_id')->references('id')->on('candidate_dynamic_forms')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('field_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_dynamic_form_fields');
    }
};
