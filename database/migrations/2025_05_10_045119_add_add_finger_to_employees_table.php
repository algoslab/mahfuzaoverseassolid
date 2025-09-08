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
        Schema::table('employees', function (Blueprint $table) {
            $table->text('add_finger')->nullable()->after('access_card');
            $table->integer('is_active_finger')->default('0')->after('add_finger');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            Schema::dropIfExists('add_finger');
            Schema::dropIfExists('is_active_finger');
        });
    }
};
