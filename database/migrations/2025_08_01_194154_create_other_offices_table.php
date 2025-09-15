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
        Schema::create('other_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('budget_carrier', ['Enabled', 'Disabled'])->default('Enabled');
            $table->string('note', 2000)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_offices');
    }
};
