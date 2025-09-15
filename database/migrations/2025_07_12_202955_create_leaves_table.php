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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('leave_type', ['Half Day Leave', 'Full Day Leave']);
            $table->enum('shift', ['Morning', 'Evening', 'Full Day'])->default('Full Day')->nullable();
            $table->string('no_of_days');
            $table->string('attachment')->nullable();
            $table->string('note', 2000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
