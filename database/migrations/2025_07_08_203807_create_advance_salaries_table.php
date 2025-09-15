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
        Schema::create('advance_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('month');
            $table->enum('payment_account', ['Bank Account', 'Cash in Hand', 'Mobile Banking', 'Office Assets']);
            $table->string('currency')->default('BDT');
            $table->decimal('amount', 25, 2);
            $table->decimal('bdt_amount', 25, 2);
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
        Schema::dropIfExists('advance_salaries');
    }
};
