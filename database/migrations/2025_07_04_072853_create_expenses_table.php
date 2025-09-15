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
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expense_category_id')->unsigned();
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('cascade');
            $table->integer('expense_item_id')->unsigned();
            $table->foreign('expense_item_id')->references('id')->on('expense_items')->onDelete('cascade');
            $table->enum('payment_method', ['Bank Account', 'Cash in Hand', 'Mobile Banking', 'Office Assets']);
            $table->string('currency')->default('BDT');
            $table->decimal('amount', 25, 2);
            $table->decimal('bdt_amount', 25, 2);
            $table->string('attachment')->nullable();
            $table->string('month_year')->nullable();
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
