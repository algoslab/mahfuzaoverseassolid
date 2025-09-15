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
        Schema::create('festival_bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->enum('amount_type', ['Percentage', 'Fixed']);
            $table->decimal('amount', 25, 2);
            $table->string('note', 2000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival_bonuses');
    }
};
