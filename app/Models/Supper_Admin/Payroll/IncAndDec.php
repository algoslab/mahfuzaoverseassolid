<?php

namespace App\Models\Supper_Admin\Payroll;

use App\Models\Admin\HRM\Employee;
use App\Models\Admin\MyOffice\Department;
use Illuminate\Database\Eloquent\Model;

class IncAndDec extends Model
{
    protected $fillable =
        [
            'department_id',
            'employee_id',
            'impression_type',
            'start_month',
            'amount_type',
            'amount',
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
