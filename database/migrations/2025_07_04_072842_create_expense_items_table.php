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
        Schema::create('expense_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expense_category_id')->unsigned();
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('cascade');
            $table->string('expense_item_name')->unique();
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
        Schema::dropIfExists('expense_items');
    }
};
