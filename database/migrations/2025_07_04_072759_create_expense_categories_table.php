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
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('account_type', ['Assets', 'Expense']);
            $table->string('expense_category_name')->unique();
            $table->string('expense_category_code')->unique();
            $table->decimal('opening_balance', 25, 2)->nullable();
            $table->string('opening_balance_sheet')->nullable();
            $table->string('note', 2000)->nullable();
            $table->enum('status', ['Enabled', 'Inactive'])->default('Enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
