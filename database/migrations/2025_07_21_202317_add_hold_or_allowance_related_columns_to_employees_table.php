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
            $table->integer('is_hold_salary')->default('0')->nullable()->after('is_active_finger');
            $table->integer('is_mobile_bill')->default('0')->nullable()->after('is_hold_salary');
            $table->integer('is_accommodation')->default('0')->nullable()->after('is_mobile_bill');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('is_hold_salary');
            $table->dropColumn('is_mobile_bill');
            $table->dropColumn('is_accommodation');
        });
    }
};
