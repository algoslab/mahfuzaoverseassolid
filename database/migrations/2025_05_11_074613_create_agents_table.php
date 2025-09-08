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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('agent_code');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->decimal('opening_balance', 25, 2)->nullable();
            $table->date('date_of_birth');
            $table->integer('take_registration_fee')->default('0');
            $table->decimal('registration_fee_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('thana_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('user_id');
            $table->text('agent_photo')->nullable();
            $table->text('passport_scan_copy')->nullable();
            $table->text('attachment')->nullable();
            $table->text('opening_balance_sheet')->nullable();
            $table->text('current_address')->nullable();
            $table->text('parmanent_address')->nullable();
            $table->text('note')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('division_id')->references('id')->on('divisions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('thana_id')->references('id')->on('thanas')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
