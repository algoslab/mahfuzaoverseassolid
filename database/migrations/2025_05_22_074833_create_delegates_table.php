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
        Schema::create('delegates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('delegate_code');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->decimal('opening_balance', 25, 2)->nullable();
            $table->unsignedBigInteger('country_id');
            $table->string('state')->nullable();
            $table->string('sponsor_type');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->text('delegate_photo')->nullable();
            $table->text('opening_balance_sheet')->nullable();
            $table->text('current_address')->nullable();
            $table->text('note')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegates');
    }
};
