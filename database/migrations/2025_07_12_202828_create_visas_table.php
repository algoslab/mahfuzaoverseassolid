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
        Schema::create('visas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sponsor_id');
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('job_list_id');
            $table->foreign('job_list_id')->references('id')->on('job_lists')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('issue_date')->nullable();
            $table->integer('age_from');
            $table->integer('age_to');
            $table->string('visa_number')->nullable();
            $table->integer('visa_qty');
            $table->enum('type', ['Air Ticket', 'Business Visa', 'Hazz & Umrah', 'Manpower', 'Patient', 'Tourist', 'Visa Processing', 'Worker'])->nullable();
            $table->enum('gender', ['Male', 'Female', 'Haji']);
            $table->string('currency')->default('BDT');
            $table->decimal('monthly_salary', 25, 2)->nullable();
            $table->decimal('salary_bdt_amount', 25, 2)->nullable();
            $table->integer('purchase_currency_id')->unsigned()->nullable();
            $table->decimal('purchase_amount', 25, 2)->nullable();
            $table->decimal('purchase_bdt_amount', 25, 2)->nullable();
            $table->enum('payment_type', ['Free', 'Due'])->nullable();
            $table->decimal('agent_price', 25, 2)->nullable();
            $table->decimal('agent_bdt_price', 25, 2)->nullable();
            $table->decimal('candidate_price', 25, 2)->nullable();
            $table->decimal('candidate_bdt_price', 25, 2)->nullable();
            $table->decimal('commission_amount', 25, 2)->nullable();
            $table->decimal('commission_bdt_amount', 25, 2)->nullable();
            $table->string('demand_letter')->nullable();
            $table->string('attachment')->nullable();
            $table->string('note', 2000)->nullable();
            $table->integer('provide_food')->default(0)->nullable();
            $table->integer('provide_accommodation')->default(0)->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visas');
    }
};
