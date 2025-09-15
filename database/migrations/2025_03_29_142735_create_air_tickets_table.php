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
        Schema::create('air_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('air_ticket_file_id')->constrained('air_ticket_files')->onDelete('cascade');
            $table->string('destination_from');
            $table->string('destination_to');
            $table->date('flight_date');
            $table->string('transit_time');
            $table->string('luggage');
            $table->string('food');
            $table->decimal('b2b_fare', 10, 2);
            $table->decimal('b2c_fare', 10, 2);
            $table->string('group');
            $table->string('full_airport_name');
            $table->string('airlines');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_tickets');
    }
};
