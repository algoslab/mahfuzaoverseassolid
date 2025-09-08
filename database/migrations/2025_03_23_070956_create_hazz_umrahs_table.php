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
        Schema::create('hazz_umrahs', function (Blueprint $table) {
            $table->id();
            $table->string('services');
            $table->string('packages');
            $table->string('transit');
            $table->string('hotel_category');
            $table->string('mokka_modina_transport')->nullable();
            $table->string('meal')->nullable();
            $table->string('days')->nullable();
            $table->string('amount_b2c')->nullable();
            $table->string('amount_b2B')->nullable();
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazz_umrahs');
    }
};
