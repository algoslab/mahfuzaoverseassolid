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
        Schema::create('asign_job_to_offices', function (Blueprint $table) {
            $table->id();
            $table->double('processing_cost',10,2);
            $table->unsignedBigInteger('proces_office_id');
            $table->unsignedBigInteger('process_category_id');
            $table->unsignedBigInteger('job_category_id');
            $table->unsignedBigInteger('job_list_id');
            $table->text('note')->nullable();
            $table->integer('status')->default(1);
            
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('proces_office_id')->references('id')->on('process_offices')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('process_category_id')->references('id')->on('process_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('job_category_id')->references('id')->on('job_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('job_list_id')->references('id')->on('job_lists')->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asign_job_to_offices');
    }
};
