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
        Schema::create('sponsor_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sponsor_id');
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('transaction_type', ['Received Payment', 'Give Payment']);
            $table->enum('payment_method', ['Bank Account', 'Cash in Hand', 'Mobile Banking', 'Office Assets']);
            $table->string('currency')->default('BDT');
            $table->decimal('amount', 25, 2);
            $table->decimal('bdt_amount', 25, 2);
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('restrict')->onUpdate('cascade');$table->string('attachment')->nullable();
            $table->string('transaction_note', 2000)->nullable();
            $table->string('note', 2000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_transactions');
    }
};
