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
        Schema::create('investor_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->enum('transaction_type', ['Recieved Payment', 'Give Payment'])->default('Recieved Payment');
            $table->enum('payment_method', ['Cash In Hand', 'Bank Account', 'Mobile Banking', 'Office Assets'])->default('Cash In Hand');
            $table->string('currency');
            $table->decimal('amount', 15, 2);
            $table->decimal('bdt_amount', 15, 2);
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->string('attachment')->nullable();
            $table->text('transaction_note')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('investor_id')->references('id')->on('investors')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_transactions');
    }
};
