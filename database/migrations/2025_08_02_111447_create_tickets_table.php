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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_name');
            $table->date('issue_date');
            $table->enum('source', ['IATA', 'Local Office', 'Budget Carrier']);
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('ticket_type', ['System Ticket - Single person', 'System Ticket - Multi person','Group Ticket - Multi person']);
            $table->unsignedBigInteger('candidate_type_id');
            $table->foreign('candidate_type_id')->references('id')->on('candidate_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('airline_office_id');
            $table->foreign('airline_office_id')->references('id')->on('airline_offices')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('other_office_id')->nullable();
            $table->foreign('other_office_id')->references('id')->on('other_offices')->cascadeOnUpdate()->restrictOnDelete();
            $table->integer('is_pre_purchase')->default(0)->nullable();
            $table->integer('is_assigned')->default(0)->nullable();
            $table->string('pnr_number');
            $table->string('attachment')->nullable();
            $table->date('flight_date');
            $table->time('flight_time');
            $table->string('flight_number');
            $table->enum('purchase_payment_type', ['Paid', 'Due'])->default('Due')->nullable();
            $table->decimal('purchase_amount', 25, 2)->nullable();
            $table->decimal('sell_amount_total', 25, 2)->nullable();
            $table->integer('total_candidate')->nullable();
            $table->decimal('per_ticket_amount', 25, 2)->nullable();
            $table->decimal('vat_or_tax_amount', 25, 2)->nullable();
            $table->decimal('partial_sell_amount', 25, 2)->nullable();
            $table->decimal('agent_commission', 25, 2)->nullable();
            $table->integer('is_refundable')->default(0)->nullable();
            $table->integer('is_make_flight_complete')->default(0)->nullable();
            $table->string('payment_type')->nullable();
            $table->enum('payment_method', ['Bank Account', 'Cash in Hand', 'Mobile Banking', 'Office Assets'])->nullable();
            $table->enum('ticket_price_payment_method', ['Bank Account', 'Cash in Hand', 'Mobile Banking', 'Office Assets'])->nullable();
            $table->string('transaction_note', 2000)->nullable();
            $table->string('note', 2000)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
