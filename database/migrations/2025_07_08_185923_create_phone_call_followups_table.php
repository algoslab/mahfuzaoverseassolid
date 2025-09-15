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
        Schema::create('phone_call_followups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phone_call_id');
            $table->unsignedBigInteger('employee_id');
            $table->enum('process', ['Continue', 'Close', 'Not Started Yet', 'Buissness Man'])->default('Not Started Yet');
            $table->text('note')->nullable();
            $table->date('followup_date')->nullable();
            $table->time('followup_time')->nullable();
            $table->timestamps();

            $table->foreign('phone_call_id')->references('id')->on('phone_calls')->cascadeOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followups');
    }
};
