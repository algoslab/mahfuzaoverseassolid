<?php

namespace App\Models\Supper_Admin\Payroll;

use App\Models\Admin\HRM\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SalaryGenerate extends Model
{
    protected $fillable =
        [
            'user_id',
            'total_employee',
            'month_year',
            'total_employee_basic_salary',
            'total_employee_grand_total_salary',
            'note'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salaryGenerateEmployees()
    {
        return $this->hasMany(SalaryGenerateEmployee::class);
    }
}
