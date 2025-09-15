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
        Schema::create('candidate_transactions', function (Blueprint $table) {
            $table->id();

            // Candidate relation
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');

            $table->enum('transaction_type', ['Recieved Payment', 'Give Payment', 'Income', 'Expense']);
            $table->string('payment_method');
            $table->string('currency')->default('BDT');
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_bdt', 12, 2);
            $table->string('transaction_purpose')->nullable();
            $table->text('transaction_note')->nullable();
            $table->text('note')->nullable();
            $table->string('attachment')->nullable();
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_transactions');
    }
};
