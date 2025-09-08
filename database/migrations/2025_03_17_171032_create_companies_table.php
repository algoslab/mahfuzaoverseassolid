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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->index();
            $table->string('company_code')->index();
            $table->date('start_date');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('alternate_number')->nullable();
            $table->string('country')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_number')->nullable();
            $table->string('owner_email')->nullable()->unique();
            $table->string('nid_no')->nullable()->unique();
            $table->text('nid_photo')->nullable();
            $table->text('comments')->nullable();
            $table->string('checkbox')->default('0');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
