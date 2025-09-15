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
        Schema::create('updated_candidate_dynamic_form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_dynamic_form_id');
            $table->foreign('candidate_dynamic_form_id', 'dynamic_form_id') // short name
            ->references('id')->on('candidate_dynamic_forms')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('field_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('updated_candidate_dynamic_form_fields');
    }
};
