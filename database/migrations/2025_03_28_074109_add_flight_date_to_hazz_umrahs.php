<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('hazz_umrahs', function (Blueprint $table) {
            $table->date('flight_date')->nullable()->after('id');
        });
    }


    public function down(): void
    {
        Schema::table('hazz_umrahs', function (Blueprint $table) {
            Schema::dropIfExists('flight_date');
        });
    }
};
