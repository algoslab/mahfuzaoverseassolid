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
        Schema::create('work_permits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('salary', 10, 2);
            $table->text('code')->nullable();
            $table->text('image')->nullable();
            $table->date('expire_date')->nullable();
            $table->unsignedBigInteger('continent_id');
            $table->unsignedBigInteger('country_id');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('continent_id')->references('id')->on('continents')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_permits');
    }
};
