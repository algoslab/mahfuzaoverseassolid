<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cell_no');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('investor_photo')->nullable();
            $table->string('nid_scan_copy')->nullable();
            $table->string('agreement_scan_copy')->nullable();
            $table->json('attachment')->nullable();
            $table->string('recieved_no', 20)->unique();
            $table->double('balance', 15, 2)->default(0);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('division_id')->references('id')->on('divisions')->cascadeOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
}; 