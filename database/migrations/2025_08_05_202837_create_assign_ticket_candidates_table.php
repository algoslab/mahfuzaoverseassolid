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
        Schema::create('assign_ticket_candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assign_ticket_id');
            $table->foreign('assign_ticket_id')->references('id')->on('assign_tickets')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id')->references('id')->on('candidates')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_ticket_candidates');
    }
};
