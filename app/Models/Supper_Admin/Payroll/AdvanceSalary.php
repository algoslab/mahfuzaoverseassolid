<?php

namespace App\Models\Supper_Admin\Payroll;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Department;
use App\Models\Supper_Admin\Location\Currency;
use Illuminate\Database\Eloquent\Model;

class AdvanceSalary extends Model
{
    protected $fillable =
        [
            'department_id',
            'employee_id',
            'month',
            'payment_account',
            'currency',
            'amount',
            'bdt_amount',
            'attachment',
            'note'
        ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
