<?php

namespace App\Models\Supper_Admin\Payroll;

use App\Models\Admin\HRM\Employee;
use Illuminate\Database\Eloquent\Model;

class SalaryGenerateEmployee extends Model
{
    protected $fillable =
        [
            'salary_generate_id',
            'employee_id',
            'month_year',
            'mobile_allowance',
            'performance_bonus',
            'inc_dec',
            'advance_salary',
            'festival_bonus',
            'employee_total_present_amount',
            'employee_weekend_days_amount',
            'employee_of_day_duty_bonus',
            'employee_holidays_amount',
            'employee_holidays_duty_bonus',
            'employee_festival_day_bonus',
            'employee_late_attendance_deduction',
            'employee_per_day_salary',
            'employee_net_salary',
            'employee_basic_salary',
            'employee_monthly_salary',
            'employee_total_salary',
            'employee_grand_total_salary',
            'employee_present',
            'employee_absent',
            'employee_half_day',
            'employee_full_day',
            'number_of_days',
            'weekend_days',
            'holidays',
            'late_attendance_days',
            'is_paid',
            'payment_method',
            'attachment',
            'transaction_note',
            'note'
        ];

    public function salaryGenerate()
    {
        return $this->belongsTo(SalaryGenerate::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
