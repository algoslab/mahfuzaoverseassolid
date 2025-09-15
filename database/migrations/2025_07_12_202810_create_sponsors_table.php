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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->enum('sponsor_type', ['Agent', 'Delegate', 'Prime Sponsor']);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('delegate_id')->nullable();
            $table->foreign('delegate_id')->references('id')->on('delegates')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('delegate_office_id')->nullable();
            $table->foreign('delegate_office_id')->references('id')->on('delegate_offices')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('sponsor_name');
            $table->string('cell_number');
            $table->string('email')->nullable();
            $table->decimal('opening_balance', 25, 2)->default(0)->nullable();
            $table->decimal('balance', 25, 2)->default(0)->nullable();
            $table->string('nid');
            $table->string('sponsor_photo')->nullable();
            $table->string('address', 2000)->nullable();
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
        Schema::dropIfExists('sponsors');
    }
};
