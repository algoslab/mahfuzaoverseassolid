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
        Schema::table('process_steps', function (Blueprint $table) {
            $table->integer('is_youtube_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('process_steps', function (Blueprint $table) {
            if (Schema::hasColumn('process_steps', 'is_youtube_link')) {
                $table->dropColumn('is_youtube_link');
            }
        });
        }
};
