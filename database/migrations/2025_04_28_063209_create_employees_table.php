<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('employee_code');
            $table->string('religion');
            $table->string('gender');
            $table->string('marital_status');
            $table->date('date_of_birth');
            $table->date('date_of_joining');
            $table->string('blood_group');
            $table->string('personal_phone');
            $table->string('personal_email')->nullable();
            $table->string('contact_person_number');
            $table->string('photo')->nullable();;
            $table->string('office_phone');
            $table->string('office_email')->nullable();
            $table->string('nid_number');
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('note', 2000)->nullable();
        
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('roster_id');
        
            $table->decimal('basic_salary_monthly', 10, 2);
            $table->decimal('basic_salary_daily', 10, 2);
            $table->decimal('mobile_allowance', 10, 2);
            $table->string('salary_pay_method');
            $table->string('contract_type');
            $table->string('access_card')->nullable();
            $table->tinyInteger('white_list')->default(0);
            $table->string('weekend_day');
        
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('designation_id')->references('id')->on('designations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('roster_id')->references('id')->on('rosters')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
