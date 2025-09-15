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
        Schema::create('visitor_books', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('full_name')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_candidate')->default(false);
            $table->unsignedBigInteger('candidate_type_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('how_find_us_id')->nullable();
            $table->string('entry_time')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->timestamps();

            $table->foreign('candidate_type_id')->references('id')->on('candidate_types')->cascadeOnDelete();
            $table->foreign('how_find_us_id')->references('id')->on('how_find_us')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_books');
    }
};
