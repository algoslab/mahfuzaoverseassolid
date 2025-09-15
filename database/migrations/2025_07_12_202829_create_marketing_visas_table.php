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
        Schema::create('marketing_visas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('job_list_id');
            $table->foreign('job_list_id')->references('id')->on('job_lists')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('type', ['Air Ticket', 'Business Visa', 'Hazz & Umrah', 'Manpower', 'Patient', 'Tourist', 'Visa processing', 'Worker']);
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('salary_currency_id')->unsigned();
            $table->foreign('salary_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('monthly_salary', 25, 2);
            $table->integer('cost_currency_id')->unsigned();
            $table->foreign('cost_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('cost', 25, 2);
            $table->integer('available_qty');
            $table->decimal('registration_fee', 25, 2);
            $table->integer('send_sms_to_agent')->default(0);
            $table->string('attachment')->nullable();
            $table->string('note', 2000)->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_visas');
    }
};
