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
        Schema::create('agent_transactions', function (Blueprint $table) {
            $table->id();

            // Candidate relation
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            $table->foreignId('care_candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->enum('transaction_type', ['Received Payment', 'Give Payment']);
            $table->string('payment_method');
            $table->string('currency')->default('BDT');
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_bdt', 12, 2);
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
        Schema::dropIfExists('agent_transactions');
    }
};
