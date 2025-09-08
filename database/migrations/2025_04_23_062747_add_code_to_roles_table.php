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
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('name');
            $table->string('code')->after('company_id')->nullable();
            $table->text('note')->after('company_id')->nullable();
            $table->integer('status')->default('1')->after('guard_name');
            $table->unsignedBigInteger('user_id')->after('status');

            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('code');
            $table->dropColumn('note');
            $table->dropColumn('status');
            $table->dropColumn('user_id');

        });
    }
};
