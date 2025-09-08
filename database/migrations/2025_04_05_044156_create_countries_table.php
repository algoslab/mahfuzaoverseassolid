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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->char('country_code', 2)->comment('country code');
            $table->string('phone_code')->comment('country code');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('continent_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('continent_id')->references('id')->on('continents')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
