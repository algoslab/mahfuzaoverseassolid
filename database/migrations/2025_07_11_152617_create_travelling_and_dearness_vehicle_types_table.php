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
        Schema::create('travelling_and_dearness_vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('travelling_and_dearness_id');
            $table->foreign('travelling_and_dearness_id', 'td_vehicle_td_id_fk')
                ->references('id')
                ->on('travelling_and_dearnesses')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->enum('vehicle_type', ['Bus', 'Rickshaw', 'CNG', 'Pathao', 'Uber', 'Van', 'Truck']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travelling_and_dearness_vehicle_types');
    }
};
