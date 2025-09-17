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
        Schema::create('candidate_type_fields', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('candidate_type_id');
            $table->string('step_name');
            $table->string('field_name');
            $table->string('attr_value');
            $table->boolean('is_enable')->default(1);
            $table->timestamps();

            $table->foreign('candidate_type_id')
                  ->references('id')
                  ->on('candidate_types')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_type_fields');
    }
};
