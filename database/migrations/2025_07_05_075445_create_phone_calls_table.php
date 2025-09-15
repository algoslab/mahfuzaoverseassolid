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
        Schema::create('phone_calls', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('candidate_type_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->boolean('is_candidate')->default(false);
            $table->text('note')->nullable();
            $table->date('followup_date')->nullable();
            $table->time('followup_time')->nullable();
            $table->unsignedBigInteger('how_find_us_id')->nullable();
            $table->enum('process', ['Continue', 'Close', 'Not Started Yet', 'Buissness Man'])->default('Not Started Yet');
            $table->enum('entry_type', ['Online', 'Menual', 'Visitor Book'])->default('Menual');
            $table->timestamps();
            
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('candidate_type_id')->references('id')->on('candidate_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('how_find_us_id')->references('id')->on('how_find_us')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_calls');
    }
};
